<?php


namespace mix8872\contentBuilder\widgets\frontend;


use yii\base\Widget;

class TextWidget extends Widget
{
    public $htmlId;
    public $className;
    public $height;
    public $content;

    public function run()
    {
        $id = htmlspecialchars($this->htmlId);
        $class = htmlspecialchars($this->className);
        $height = htmlspecialchars($this->height);
        $content = htmlspecialchars($this->content);

        $attributes = [];
        if ($id) {
            $attributes['id'] = $id;
        }
        if ($class) {
            $attributes['class'] = $class;
        }
        if ($height) {
            $attributes['style'] = "height:$height";
        }

        return $this->render('text', compact('attributes', 'content'));
    }
}