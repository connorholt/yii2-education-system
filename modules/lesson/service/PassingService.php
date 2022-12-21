<?php

namespace app\modules\lesson\service;

use app\modules\lesson\models\Lessons;
use app\modules\lesson\models\Passing;
use Yii;

class PassingService
{

    public function allPassed(): bool {
        return !Lessons::find()
            ->leftJoin("passing", "passing.lesson_id = lessons.id")
            ->andWhere("passing.id IS NULL")
            ->andWhere(["or",
                ["=", "passing.user_id", Yii::$app->user->id],
                "passing.user_id IS NULL"
            ])
            ->exists();
    }

    // todo in model
    public function getNextLesson() {
        return Lessons::find()
            ->leftJoin("passing", "passing.lesson_id = lessons.id")
            ->andWhere("passing.id IS NULL")
            ->andWhere(["or",
                ["=", "passing.user_id", Yii::$app->user->id],
                "passing.user_id IS NULL"
            ])
            ->orderBy("lessons.id")
            ->one();
    }
}