<?php
namespace common\models;

use common\behaviors\PositionBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\behaviors\JsonFields;

class BaseDataModel extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOTACTIVE = 0;

    public function rules()
    {
        return [
            [['position', 'status', 'created_at', 'updated_at'], 'integer'],
            [ 'additional_data', 'safe']
        ];
    }

    public function behaviors()
    {
        return [
            PositionBehavior::className(),
            TimestampBehavior::className(),
            'jsonFields' => [
                'class' => JsonFields::className(),
                'fields' => [
                    'additional_data'
                ]
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Позиция',
            'status' => 'Статус',
            'created_at' => 'Создано',
            'updated_at' => 'Редактирована',
        ];
    }

    static public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_NOTACTIVE => 'Неактивна'
        ];
    }

    public function getStatusDetail()
    {
        return isset(self::getStatusList()[$this->status]) ? self::getStatusList()[$this->status] : '';
    }
}