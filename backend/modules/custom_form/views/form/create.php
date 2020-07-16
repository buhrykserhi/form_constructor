<?php
use yii\helpers\Html;

$this->title = 'Создание';
$this->params['breadcrumbs'][] = ['label' => 'Формы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">
    <div class="col-md-12" style="text-align: right">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'onClick' =>'validForm()' ]) ?>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
