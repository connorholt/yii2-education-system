<?php

namespace app\modules\lesson\controllers;

use app\modules\lesson\models\Lessons;
use app\modules\lesson\models\Passing;
use app\modules\lesson\service\PassingService;
use app\modules\user\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LessonsController implements the CRUD actions for Lessons model.
 */
class LessonsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'pass', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isUserAdmin();
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * Lists all Lessons models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Lessons::find();
        $query->with("passing");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'user' => Yii::$app->user->identity
        ]);
    }

    /**
     * Displays a single Lessons model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Lessons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Lessons();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // todo string return type
    public function actionPass($id): string
    {
        $model = $this->findModel($id);
        $passingModel = new Passing();
        $passingModel->lesson_id = $model->id;
        $passingModel->user_id = Yii::$app->user->id;
        $passingModel->save();

        $passingService = new PassingService();
        if ($passingService->allPassed()) {
            return $this->renderPartial('passed', [
                'model' => $model,
            ]);
        }

        $model = $passingService->getNextLesson();
        return $this->renderPartial('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lessons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lessons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Lessons::STATUS_DELETED;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lessons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Lessons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lessons::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
