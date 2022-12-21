<?php

namespace app\modules\lesson\service;

use app\modules\lesson\models\Lessons;
use app\modules\lesson\models\Passing;
use Yii;

class PassingService
{

    public function allPassed(): bool {
        return !Lessons::findWithPassion()
            ->exists();
    }

    // todo in model
    public function getNextLesson() {
        return Lessons::findWithPassion()
            ->orderBy("lessons.id")
            ->one();
    }
}