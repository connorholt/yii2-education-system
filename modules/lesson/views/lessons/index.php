<?php

use app\modules\lesson\models\Lessons;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \app\modules\user\models\User $user */

$this->title = 'Lessons';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    'id',
    [
        'attribute' => 'title',
        'value' => function (Lessons $model) {
            return Html::a(Html::encode($model->title), Url::to(['view', 'id' => $model->id]));
        },
        'format' => 'raw',
    ],
    'description:ntext',
];

if ($user->isUserAdmin()) {
    $columns[] = [
        'value' => function (Lessons $model) {
            return Html::a("Редактировать", Url::to(['update', 'id' => $model->id]));
        },
        'format' => 'raw',
    ];
    $columns[] = [
        'value' => function (Lessons $model) {
            return Html::a("Удалить", Url::to(['delete', 'id' => $model->id]));
        },
        'format' => 'raw',
    ];
} else {
    $columns[] = [
        'header' => 'Урок пройден',
        'contentOptions' => ['style' => 'color:green'],
        'value'=> function ($model, $key, $index, $column) {
            return $model->passing ? "✓" : "";
        },
    ];
}
?>
<div class="lessons-index">

    <h1>Уроки</h1>

    <p>
        <?php
        if ($user->isUserAdmin()) {
            echo Html::a('Добавить урок', ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns
    ]); ?>


</div>
