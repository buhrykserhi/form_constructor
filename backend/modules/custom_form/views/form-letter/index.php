<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\custom_form\models\FormLetter as CurrentModel;


$this->title = 'Письма';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-index">
    <div class="row">
        <div class="col-md-9">
<!--            --><?//= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Добавить', ['create'], ['class' => 'btn btn-success block right']) ?>
            <div class="pull-right">
                <?=\backend\widgets\GroupActionWidge::widget(['delete' => true, 'activate' => true, 'deactivate' => true, 'className' => CurrentModel::className()]) ?>
            </div>
            <?php Pjax::begin(['id' => 'content-list']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-custom dataTable no-footer'],
                'class'=>'table table-custom dataTable no-footer',
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'contentOptions'=>['style'=>'width: 10px;', 'class' => 'checkbox-item'],
                    ],
                    [
                        'format' => 'raw',
                        'contentOptions'=>['style'=>'width: 10px;', 'class' => 'sort-item'],
                        'value' => function() {
                            return '<i class="fa fa-arrows-alt"> </i>';
                        }
                    ],

                    'id',
                    [
                        'attribute' => 'title',
                        'value' => function($model){
                            return $model->form->title;
                        }
                    ],
//                    [
//                        'attribute' => 'status',
//                        'filter' => $searchModel::getStatusList(),
//                        'value' => 'statusDetail'
//                    ],
                    'updated_at:datetime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {delete}',
                    ]
                ],
            ]); ?>
            <?php Pjax::end() ?>
        </div>
    </div>

</div>
