<?php
namespace backend\controllers;

use backend\components\actions\GetImagesAction;
use backend\components\actions\UploadFileAction;

use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

class BaseController extends Controller
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => UploadFileAction::className(),
                'url' => '/uploads/page',
                'path' => '@frontend/web/uploads/page',
                'uploadOnlyImage' => false,
            ],
            'get-image' => [
                  'class' => GetImagesAction::className(),
                  'url' => '/uploads/page/',
                  'path' => '@frontend/web/uploads/page',
                  'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']],
            ]
        ];
    }

    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}