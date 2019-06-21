<?php


namespace mix8872\contentBuilder\widgets\frontend;


use yii\base\Widget;

class ImageWidget extends Widget
{
    public $htmlId;
    public $className;
    public $url;
    public $width;
    public $height;
    public $title;
    public $alt;
    public $description;

    public function run()
    {
        $id = htmlspecialchars($this->htmlId);
        $class = htmlspecialchars($this->className);
        $height = htmlspecialchars($this->height);
        $width = htmlspecialchars($this->width);
        $url = htmlspecialchars($this->url);
        $title = htmlspecialchars($this->title);
        $alt = htmlspecialchars($this->alt);
        $description = htmlspecialchars($this->description);

        $attributes = [];
        if ($id) {
            $attributes['id'] = $id;
        }
        if ($class) {
            $attributes['class'] = $class;
        }
        if ($height) {
            $attributes['height'] = htmlspecialchars($height);
        }
        if ($width) {
            $attributes['width'] = htmlspecialchars($width);
        }
        return $this->render('image', compact('attributes', 'url', 'title', 'alt', 'description'));
    }
}