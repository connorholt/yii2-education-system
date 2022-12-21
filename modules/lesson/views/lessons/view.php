<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\lesson\models\Lessons $model */

\yii\web\YiiAsset::register($this);
?>
<div class="lessons-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <h2><?=$model->title ?></h2>
    <iframe width="420" height="315" src="<?= Html::encode($model->video_url) ?>"></iframe>
    <p><?=$model->description ?></p>
    <p>
        <?= Html::a('Ко всем урокам', ['index'], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Урок пройден','#', [
            'class' => 'btn btn-primary',
            'onclick'=>"
                $.ajax({
                    type: 'GET',
                    data: {
                        id: " .  $model->id . "
                    },
                    url: 'pass',
                    success  : function(response) {
                        $('#main').find('.container').find('div.lessons-view').remove()
                        $('#main').find('.container').append(response)
                    }
                    });return false;",
        ]);
        ?>
    </p>

</div>
