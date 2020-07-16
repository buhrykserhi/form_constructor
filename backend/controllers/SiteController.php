<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'group' => [
                'class' => 'backend\components\GroupAction',
            ],
            'sort' => [
                'class' => 'backend\components\SortAction',
            ],
        ];
    }

}
