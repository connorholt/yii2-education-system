<?php

namespace app\modules\lesson\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "lessons".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $title
 * @property string|null $description
 * @property string $video_url
 * @property int $status
 */
class Lessons extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_DELETED = 1;

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public static function find(): ActiveQuery
    {
        return parent::find()
            ->where(['!=', 'lessons.status',  self::STATUS_DELETED]);
    }

    public static function getStatusesArray(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_DELETED => 'Удален',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлён',
            'title' => 'Название урока',
            'description' => 'Описание',
        ];
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
    public static function tableName(): string
    {
        return 'lessons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'video_url'], 'required'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['video_url'], 'string', 'max' => 250],
            [['title'], 'unique'],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

        ];
    }

    public function getPassing(): ActiveQuery
    {
        return $this->hasOne(Passing::class, ['lesson_id' => 'id'])
            ->where("user_id = :user_id", [":user_id" => Yii::$app->user->id]);
    }

    public static function findWithPassing(): ActiveQuery
    {
        return self::find()
            ->leftJoin("passing", "passing.lesson_id = lessons.id")
            ->andWhere("passing.id IS NULL")
            ->andWhere(["or",
                ["=", "passing.user_id", Yii::$app->user->id],
                "passing.user_id IS NULL"
            ]);
    }
}
