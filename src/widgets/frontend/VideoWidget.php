<?php


namespace mix8872\contentBuilder\widgets\frontend;


use yii\base\Widget;

class VideoWidget extends Widget
{
    public $htmlId;
    public $className;
    public $urlMp4;
    public $urlWebm;
    public $title;
    public $description;
    public $poster;
    public $loop = false;
    public $muted = false;
    public $autoplay = false;
    public $controls = true;

    public function run()
    {
        $id = htmlspecialchars($this->htmlId);
        $class = htmlspecialchars($this->className);
        $urlMp4 = htmlspecialchars($this->urlMp4);
        $urlWebm = htmlspecialchars($this->urlWebm);
        $title = htmlspecialchars($this->title);
        $description = htmlspecialchars($this->description);
        $poster = htmlspecialchars($this->poster);
        $loop = (bool)htmlspecialchars($this->loop);
        $muted = (bool)htmlspecialchars($this->muted);
        $autoplay = (bool)htmlspecialchars($this->autoplay);
        $controls = (bool)htmlspecialchars($this->controls);

        $attributes = [];
        if ($id) {
            $attributes['id'] = $id;
        }
        if ($class) {
            $attributes['class'] = $class;
        }
        if ($loop) {
            $attributes['loop'] = htmlspecialchars($height);
        }
        if ($muted) {
            $attributes['muted'] = htmlspecialchars($muted);
        }
        if ($autoplay) {
            $attributes['autoplay'] = htmlspecialchars($autoplay);
        }
        if ($controls) {
            $attributes['controls'] = htmlspecialchars($controls);
        }
        if ($poster) {
            $attributes['poster'] = htmlspecialchars($poster);
        }
        return $this->render('video', compact('attributes', 'urlMp4', 'urlWebm', 'title', 'description', 'poster'));
    }
}