<?php
namespace frontend\controllers;

use backend\modules\custom_form\models\FormLetter;
use Yii;
use yii\web\Controller;


class FormController extends Controller
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new FormLetter();

        $postData = Yii::$app->request->post();

        if (Yii::$app->request->method == 'POST') {
            if (!empty($_FILES)) {
                $postData['field']['Файл'] = $_FILES['Файл']['name'];

                $file = $_FILES['Файл']['name'];
                move_uploaded_file($_FILES['Файл']['tmp_name'], 'uploads/contact/' . $file);
            }

        }

        $model->form_id = Yii::$app->request->post('form_id');
        $model->additional_data = $postData;
        $model->save();

        Yii::$app->mailer->compose('contactForm', ['data' => $postData['field']])
            ->setFrom($postData['field']['E-mail'])
            ->setTo(explode(',', $postData['email']))
            ->setSubject('Your site | Форма | '. $postData['title'])
            ->send();

//            Yii::$app->response->format = Response::FORMAT_JSON;
            return 'true';

    }
}
