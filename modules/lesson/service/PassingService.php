<?php

namespace app\modules\lesson\service;

use app\modules\lesson\models\Lessons;
use app\modules\lesson\models\Passing;
use Yii;

class PassingService
{

    public function allPassed(): bool {
        return !Lessons::findWithPassing()
            ->exists();
    }

    public function getNextLesson() {
        return Lessons::findWithPassing()
            ->orderBy("lessons.id")
            ->one();
    }
}