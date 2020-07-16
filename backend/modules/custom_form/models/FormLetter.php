<?php

namespace backend\modules\custom_form\models;

use common\models\BaseDataModel;

class FormLetter extends BaseDataModel
{

    const ADDITIONAL_DATA_ITEMS = 'items';

    static $current = null;

    public static function tableName()
    {
        return 'custom_form_letter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['form_id'], 'integer'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'form_id' => 'Форма',
        ]);
    }

    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'form_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

}
