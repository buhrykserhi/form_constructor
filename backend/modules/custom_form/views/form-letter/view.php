<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Письма', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <p>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <h2>Данные из формы</h2>
    <table id="w0" class="table table-striped table-bordered detail-view">
        <tbody>
            <?php foreach ($model->additional_data['field'] as $key => $item): ?>
            <?php if ($key == 'Файл') : ?>
                <tr>
                    <th><?= $key ?></th>
                    <td><a href="/frontend/web/uploads/letter/<?= $item ?>"><?= $item ?></a></td>
                </tr>
            <?php else: ?>
                    <tr>
                        <th><?= $key ?></th>
                        <td><?= is_array($item) ? implode('| ', $item) : $item ?></td>
                    </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <h2>Дополнительные данные</h2>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'form_id',
                'value' => function($model){
                    return $model->form->title;
                }
            ],

//            [
//                'attribute' => 'status',
//                'value' => function($model) {
//                    return $model->statusDetail;
//                },
//            ],
//            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
