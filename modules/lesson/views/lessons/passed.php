<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\lesson\models\Lessons $model */

\yii\web\YiiAsset::register($this);
?>
<div class="lessons-view">

    <h1>Курс пройден!</h1>
    <p>
        Спасибо что прошли этот курс!
    </p>
    <p>
        <?= Html::a('Ко всем урокам', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
