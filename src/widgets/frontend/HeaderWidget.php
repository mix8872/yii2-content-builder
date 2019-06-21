<?php


namespace mix8872\contentBuilder\widgets\frontend;


use yii\base\Widget;

class HeaderWidget extends Widget
{
    public $htmlId;
    public $className;
    public $size;
    public $content;

    public function run()
    {
        $id = htmlspecialchars($this->htmlId);
        $class = htmlspecialchars($this->className);
        $size = htmlspecialchars($this->size)[1];
        $content = htmlspecialchars($this->content);

        $attributes = [];
        if ($id) {
            $attributes['id'] = $id;
        }
        if ($class) {
            $attributes['class'] = $class;
        }

        return $this->render('header', compact('attributes', 'size', 'content'));
    }
}