<?php
/**
 * Created by PhpStorm.
 * User: Mix
 * Date: 04.10.2018
 * Time: 10:38
 */

namespace mix8872\contentBuilder\widgets;

use Yii;
use yii\base\Security;

class ContentBuilder extends \yii\widgets\InputWidget
{
    /*
     * {@inheritdoc}
     * */
    public function init()
    {
        parent::init();
    }

    /*
     * {@inheritdoc}
     * */
    public function run()
    {
        $module = Yii::$app->getModule('content-builder');
        $rootId = rand(100000,999999);

        foreach ($module->elements as &$element) {
            $newAttr = array();
            foreach($element['attributes'] as $attribute) {
                $newAttr[] = $attribute;
            }
            $element['attributes'] = $newAttr;
        }

        if ($this->hasModel()) {
            return $this->render('index',[
                'model' => $this->model,
                'attribute' => $this->attribute,
                'config' => $module->elements,
                'rootId' => 'editor' . $rootId
            ]);
        }
        return false;
    }
}