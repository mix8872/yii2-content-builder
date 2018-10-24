<?php
/**
 * Created by PhpStorm.
 * User: Mix
 * Date: 04.10.2018
 * Time: 12:58
 */

namespace mix8872\contentBuilder\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

class DefaultController extends \yii\web\Controller
{
    private $file;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $module = Yii::$app->getModule('content-builder');
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'upload' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $module->imageUpload['uploadRolesAccess'] ?? ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['image'],
                        'roles' => ['?', '@']
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['upload'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $module = Yii::$app->controller->module;
        return 'Hello';
    }

    public function actionUpload($single = 0)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $this->file = UploadedFile::getInstanceByName('image');

        if ($this->file) {
            $imageUpload = $this->module->imageUpload;
            $path = Yii::getAlias('@webroot' . $imageUpload['uploadUrl']);

            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            $filename = (new \yii\base\Security())->generateRandomString(10) . '.' . $this->file->extension;
            list($width) = getimagesize($this->file->tempName);

            if ($this->_saveFile($path . '/' . $filename)) {
                $out = array();
                if (!$single) {
                    foreach ($imageUpload['sizes'] as $size) {
                        if ($size < $width) {
                            $out[$size] = Url::to(['image', 'f' => $filename, 's' => $size]);
                        }
                    }
                    $out['default'] = Url::to(['image', 'f' => $filename]);
                } else {
                    $url = Url::to(['image', 'f' => $filename]);
                    $url = preg_replace('/\/(ru|en)\//ui', '/', $url);
                    $out = [
                        'data' => ['link' => $url]
                    ];
                }
                return $out;
            }
        }
        return [];
    }

    public function actionImage($f, $s = false)
    {
        $f = trim(strip_tags($f));
        $imageUpload = $this->module->imageUpload;
        $file = Yii::getAlias('@webroot' . $imageUpload['uploadUrl']) . '/' . $f;
        if (!file_exists($file)) {
            throw new NotFoundHttpException("Image doen't exist!");
        }

        $finfo = pathinfo($file);
        if ($finfo['extension'] === 'svg') {

//            header('Content-Type: image/svg; charset=UTF-8');
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', 'image/svg+xml');
//            Yii::$app->response->headers->set('Content-Type', 'image/svg; charset=UTF-8');
            /*$this->layout = 'img';
            return $this->render('img', [
                'file' => file_get_contents($file)
            ]);*/

//            return Yii::$app->response->xSendFile($file, $finfo['basename'],['inline' => true, 'contentType' => 'image/svg']);
            return file_get_contents($file);
        } else {
            if ($s) {
                return Image::getImagine()
                    ->open($file)
                    ->thumbnail(new Box((int)$s, 10000))
                    ->show($finfo['extension'], []);
            } else {
                return Image::getImagine()
                    ->open($file)
                    ->show($finfo['extension'], []);
            };
        }

    }

    private function _saveFile($path)
    {
        if ($this->file) {
            $imageUpload = $this->module->imageUpload;
            if (is_array($imageUpload['origResize']) && (isset($imageUpload['origResize']['width']) || isset($imageUpload['origResize']['height']))) {

                $width = $imageUpload['origResize']['width'] ?? 10000;
                $height = $imageUpload['origResize']['height'] ?? 10000;

                return Image::getImagine()->open($this->file->tempName)
                    ->thumbnail(new Box($width, $height))
                    ->save($path);
            } else {
                return $this->file->saveAs($path);
            }
        }
        return false;
    }
}