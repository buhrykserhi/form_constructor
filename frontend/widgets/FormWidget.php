<?php
namespace frontend\widgets;

use \backend\modules\custom_form\models\Form;

class FormWidget extends \yii\bootstrap\Widget
{
    public $form;
    public $form_title;
    public $form_data;
    public $fields;


    public function init(){
        $model_form = Form::findOne($this->form);
        $this->form_data = $model_form;
        $this->fields = $model_form->getData(Form::ADDITIONAL_DATA_ITEMS) ?: [];
    }

    public function run() {
        return $this->render('form', [
            'fields' => $this->fields,
            'form_title' => $this->form_title,
            'form_data' => $this->form_data,
            'form_id' => $this->form,
        ]);
    }
}