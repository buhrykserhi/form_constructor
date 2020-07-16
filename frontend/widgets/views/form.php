<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \backend\modules\custom_form\models\Form;
use frontend\assets\CustomFormAsset;

CustomFormAsset::register($this);
?>
<div class="popup form_pop" data-popup="forma_<?= $form_data->id ?>">
    <?php $form = ActiveForm::begin([
        'id' => 'cooperateForm-'.$form_data->id,
        'options' => [
                'enctype' => 'multipart/form-data',
            'onsubmit' => 'return false',
            'data-url' => Url::to(['/form/create']),
            'data-success-message' => Yii::t('request', 'Ваша заявка успешно отправлена')
        ]
    ]); ?>

    <div class="p">
        <?php foreach ($fields as $field): ?>
            <?php if ($field['type'] == Form::TYPE_TEXT): ?>
                <span><input class="input" name="field[<?= $field['name'] ?>]" type="text" placeholder="<?= Yii::t('form', $field['placeholder']) ?>"></span>
            <?php endif; ?>
            <?php if ($field['type'] == Form::TYPE_EMAIL): ?>
                <span><input class="input" required   name="field[<?= $field['name'] ?>]" type="text" placeholder="<?= Yii::t('form', $field['placeholder']) ?>"></span>
            <?php endif; ?>
            <?php if ($field['type'] == Form::TYPE_PHONE): ?>
                <span><input class="input"   name="field[<?= $field['name'] ?>]" type="tel" placeholder="<?= Yii::t('form', $field['placeholder']) ?>"></span>
                <?php $this->registerJs("
                    var selector = $('input[type=\'tel\']');
                    var im = new Inputmask(\"+38(999)999-99-99\");
                    im.mask(selector);
                ",
                    \yii\web\View::POS_READY,
                    'my-button-handler'
                ); ?>
            <?php endif; ?>
            <?php if ($field['type'] == Form::TYPE_AREA): ?>
                <span><textarea class="textarea"  name="field[<?= $field['name'] ?>]" placeholder="<?= Yii::t('form', $field['placeholder']) ?>"></textarea></span>
            <?php endif; ?>
            <?php if ($field['type'] == Form::TYPE_SELECT): ?>
                <div class="input-box select-box custom-select">
                <select   name="field[<?= $field['name'] ?>]">
                    <option value=""><?= Yii::t('form', $field['placeholder']) ?></option>
                    <?php foreach ( explode("\n", $field['option']) as $item): ?>
                        <option value="<?= $item ?>"><?= $item ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
            <?php endif; ?>

            <?php if ($field['type'] == Form::TYPE_FILE):  ?>

                <div class="file-inpt-dev">
                    <input type="file" name="Файл">
                    <label style="margin-bottom: 40px;" class="file">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M22.996 10.8H21.6V8.2928C21.6 7.6904 21.1096 7.2 20.5072 7.2H19.2V6.2344L19.002 6.0364C19.0016 6.0364 19.0016 6.036 19.0016 6.0356L16.0832 3.1172L12.9656 0H3.2V4.4H1.0928C0.4904 4.4 0 4.8904 0 5.4928V22.9676H0.0024C0.0004 23.1928 0.0704 23.4132 0.2112 23.5976C0.4072 23.8536 0.704 24 1.026 24H18.9296C19.392 24 19.7992 23.6884 19.9096 23.2748L24 12.0596V11.9888C24 11.3 23.5776 10.8 22.996 10.8ZM20.5072 8C20.6684 8 20.8 8.1312 20.8 8.2928V10.8H19.2V8H20.5072ZM13.2 1.366L17.8344 6H13.2V1.366ZM4 0.8H12.4V6.8H18.4V7.2V10.8H5.0924C5.0352 10.8 4.9788 10.8048 4.9236 10.814C4.534 10.8788 4.2092 11.1628 4.1124 11.5252L4 11.834V4.4V0.8ZM0.8 5.4928C0.8 5.3312 0.9316 5.2 1.0928 5.2H3.2V14.014L0.8 20.5596V5.4928ZM19.1476 23.0332C19.1212 23.1312 19.0316 23.2 18.9296 23.2H1.026C0.9288 23.2 0.872 23.1444 0.8468 23.1112C0.8216 23.0784 0.7828 23.0088 0.7976 22.948L3.2 16.3592V16.3612L4.864 11.7996L4.8744 11.7668C4.9008 11.6688 4.9908 11.6 5.0924 11.6H18.4H19.2H21.6H22.996C23.148 11.6 23.1868 11.8184 23.1968 11.9276L19.1476 23.0332Z" fill="white"></path>
                            <path d="M6.4 6.8H10.4C10.6208 6.8 10.8 6.6212 10.8 6.4C10.8 6.1788 10.6208 6 10.4 6H6.4C6.1792 6 6 6.1788 6 6.4C6 6.6212 6.1792 6.8 6.4 6.8Z" fill="white"></path>
                            <path d="M6.4 3.99995H10.4C10.6208 3.99995 10.8 3.82115 10.8 3.59995C10.8 3.37875 10.6208 3.19995 10.4 3.19995H6.4C6.1792 3.19995 6 3.37875 6 3.59995C6 3.82115 6.1792 3.99995 6.4 3.99995Z" fill="white"></path>
                            <path d="M6.4 9.60005H16C16.2208 9.60005 16.4 9.42125 16.4 9.20005C16.4 8.97885 16.2208 8.80005 16 8.80005H6.4C6.1792 8.80005 6 8.97885 6 9.20005C6 9.42125 6.1792 9.60005 6.4 9.60005Z" fill="white"></path>
                        </svg>
                        <span><?= Yii::t('form','прикрепить файл') ?></span>
                    </label>
                </div>
            <?php endif; ?>

            <?php if ($field['type'] == Form::TYPE_CHECKBOX): ?>
                <p class="popup-checkbox"><?= Yii::t('form', $field['placeholder']) ?></p>
                <?php $i = 0; foreach ( explode("\n", $field['option']) as $item): ?>
                    <div class="check-box">
                        <input type="checkbox" name="field[<?= $field['name'] ?>][]" id="<?= $form_id . '-' . $item ?>" value="<?= $item ?>">
                        <label for="<?= $item ?>"><?= Yii::t('form',$item) ?></label>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <input type="hidden" name="field[Название секции]" value="<?= $form_title ?>">
        <input type="hidden" name="form_id" value="<?= $form_id ?>">
        <input type="hidden" name="title" value="<?= $form_data->title ?>">
        <input type="hidden" name="email" value="<?= $form_data->email ?>">

        <input type="submit"  class="btn-orange create_form" value="<?= Yii::t('form', $form_data->button) ?>">
    </div>

    <?php ActiveForm::end(); ?>
    <div class="exit-btn"></div>
</div>

<div class="popup popup-dev-thx" id="popup-success">
    <h2></h2>
    <div class="exit-btn"></div>
</div>