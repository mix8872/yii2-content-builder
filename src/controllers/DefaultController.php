<?php
/**
 * Created by PhpStorm.
 * User: Mix
 * Date: 04.10.2018
 * Time: 12:58
 */

namespace mix8872\contentBuilder\controllers;

use Yii;
use yii\filters\VerbFilter;

class DefaultController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $module = Yii::$app->controller->module;
        return 'Hello';
    }
}