<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>Пользователи</h1>

    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            [
                'value' => function (User $model) {
                    return Html::a("Редактировать", Url::to(['update', 'id' => $model->id]));
                },
                'format' => 'raw',
            ],
            [
                'value' => function (User $model) {
                    return Html::a("Удалить", Url::to(['delete', 'id' => $model->id]));
                },
                'format' => 'raw',
            ]
        ]
    ]); ?>


</div>
