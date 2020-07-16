<?php

namespace backend\modules\custom_form\controllers;

use backend\modules\custom_form\models\FormLetter;
use backend\modules\custom_form\models\FormLetterSearch;
use backend\controllers\BaseController;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `custom_form` module
 */
class FormLetterController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new FormLetterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = FormLetter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
