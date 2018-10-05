<?php
/**
 * Created by PhpStorm.
 * User: Mix
 * Date: 04.10.2018
 * Time: 10:44
 */

namespace mix8872\contentBuilder\assets;


class ContentBuilderAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/mix8872/yii2-content-builder/src/assets';
    public $css = [
        'main.css',
    ];
    public $js = [
//        'service-worker.js',
        'main.js'
    ];
}