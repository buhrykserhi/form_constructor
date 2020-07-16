<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\FrontendAsset;
use backend\assets\RedactorAsset;
use yii\widgets\Pjax;
use backend\modules\custom_form\models\Form;

FrontendAsset::register($this);
RedactorAsset::register($this);

\backend\widgets\SortWidget::widget(['className' => Form::className()]);
$items = $model->getData(Form::ADDITIONAL_DATA_ITEMS) ?: [];
$add = Yii::$app->request->get('add-items');
?>

<?php $form = ActiveForm::begin(['id'=>'form']); ?>

<div class="page-form">
    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'button')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <?php if (!$model->isNewRecord): ?>
        <?php Pjax::begin(['id' => 'content-list']) ?>
            <div class="col-md-12">
            <table class="table table-custom dataTable no-footer"><thead>
                <tr>

                    <th></th>
                    <th>Placeholder</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Options</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody class="ui-sortable">
                <?php foreach ($items as $key => $item) : ?>
                    <tr data-key="2">
                        <td class="sort-item ui-sortable-handle" style="width: 10px;">
                            <i class="fa fa-arrows-alt"> </i>
                        </td>

                        <td> <input type="text" name="fields[<?= $key ?>][placeholder]" value="<?=  $item['placeholder'] ?>"></td>
                        <td> <input type="text" name="fields[<?= $key ?>][name]" value="<?=  $item['name'] ?>"></td>
                        <td>
                            <?=  Html::dropDownList('fields['.$key.'][type]', $item['type'], Form::getTypeList()); ?>
                        </td>
                        <td> <textarea name="fields[<?= $key ?>][option]"><?=  $item['option'] ?></textarea></td>
                        <td><a href="#" class="widget-delete-item" title="Delete" ><i class="glyphicon glyphicon-trash"></i> </a></td>
                    </tr>

                <?php endforeach; ?>
                <?php if ($add): ?>
                    <?php $key = $key + 1; ?>
                    <tr data-key="2">
                        <td class="sort-item ui-sortable-handle" style="width: 10px;">
                            <i class="fa fa-arrows-alt"> </i>
                        </td>
                        <td> <input type="text" name="fields[<?= $key ?>][placeholder]" ></td>
                        <td> <input type="text" name="fields[<?= $key ?>][name]" ></td>
                        <td>
                            <?=  Html::dropDownList('fields['.$key.'][type]', '', Form::getTypeList()); ?>
                        </td>
                        <td> <textarea name="fields[<?= $key ?>][option]"></textarea></td>
                        <td><a href="#" class="widget-delete-item" title="Delete" ><i class="glyphicon glyphicon-trash"></i> </a></td>
                    </tr>
                    <?=$this->registerJs("
        $('select').on('change', function() {
            $('#save').click();
        }); 
    ", \yii\web\View::POS_READY) ?>

                <?php else:; ?>
                    <hr>
                    <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add item', ['update', 'id' => $model->id,  'add-items' => 'colum'], ['class' => 'btn btn-success btn-sm']) ?>
                <?php endif; ?>
                </tbody></table>
            <hr>
        </div>
        <?php Pjax::end() ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
