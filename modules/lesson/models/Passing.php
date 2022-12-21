<?php

namespace app\modules\lesson\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "passing".
 *
 * @property int $id
 * @property int $user_id
 * @property int $lesson_id
 * @property int $created_at
 * @property int $updated_at
 */
class Passing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'passing';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'lesson_id'], 'required'],
            [['user_id', 'lesson_id'], 'default', 'value' => null],
            [['user_id', 'lesson_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'lesson_id' => 'Lesson ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
