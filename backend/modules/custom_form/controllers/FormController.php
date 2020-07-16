<?php

namespace backend\modules\custom_form\controllers;

use backend\modules\custom_form\models\Form;
use backend\modules\custom_form\models\FormSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;

/**
 * Default controller for the `custom_form` module
 */
class FormController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new FormSearch();
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


    public function actionCreate()
    {
        $model = new Form();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $new_data = [];

            if ($data = Yii::$app->request->post('fields')) {

                foreach ($data as $k => $item) {
                    if (!isset($item['delete'])) {
                        $new_data[$k] = $item;
                    }
                }
            }

            $model->setData($model::ADDITIONAL_DATA_ITEMS, $new_data);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Зміни збережено');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Form::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
