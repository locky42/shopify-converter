<?php

namespace app\controllers;

use Exception;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;
use app\models\UploadForm;
use app\services\EcoLightConverter;

class ConverterController extends Controller
{
    public $enableCsrfValidation = false;
    protected $data;

    /**
     * @param $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        $this->data = Yii::$app->request->post();
        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * @throws Exception
     */
    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->upload()) {
                $service = new EcoLightConverter($model->file);
                return $service->convert();
            }
        }

        return $this->redirect(['site/index']);
    }
}
