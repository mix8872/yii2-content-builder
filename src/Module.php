<?php

namespace mix8872\contentBuilder;

use Yii;

class Module extends \yii\base\Module
{
    public $elements;
    public $imageUpload;

    /*
     * {@inheritdoc}
     * */
    public function init()
    {
        parent::init();
        $this->controllerNamespace = 'mix8872\contentBuilder\controllers';
        $this->setViewPath('@vendor/mix8872/yii2-content-builder/src/views');
        $this->registerTranslations();
        $this->setElements();
        $this->setImageUpload();
        if (empty($this->imageUpload['uploadRolesAccess'])) {
            $this->imageUpload['uploadRolesAccess'] = ['@'];
        }
    }

    /**
     * Register translation for module
     */
    public function registerTranslations()
    {
        \Yii::$app->i18n->translations['contentbuilder'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru-RU',
            'basePath' => '@vendor/mix8872/yii2-content-builder/src/messages',
        ];

    }

    private function setImageUpload()
    {
        $this->imageUpload = \yii\helpers\ArrayHelper::merge([
            'uploadRolesAccess' => [],
            'uploadUrl' => '/uploads/images',
            'origResize' => false,
            'sizes' => [],
        ], $this->imageUpload);
    }

    /*
     * Set elements config
     * */
    private function setElements()
    {
        $this->elements = \yii\helpers\ArrayHelper::merge([
            'Header' => [
                'label' => Yii::t('contentbuilder', 'Заголовок'),
                'description' => Yii::t('contentbuilder', 'Заголовок'),
                'icon' => 'fa fa-header',
                'class' => 'contentBuilder\widgets\HeaderWidget',
                'attributes' => [
                    'size' => [
                        'name' => Yii::t('contentbuilder', 'Размер'),
                        'attr' => 'size',
                        'type' => 'select',
                        'default' => 'h2',
                        'variants' => [
                            'h1',
                            'h2',
                            'h3',
                            'h4',
                            'h5',
                            'h6'
                        ]
                    ],
                    'content' => [
                        'name' => Yii::t('contentbuilder', 'Заголовок'),
                        'attr' => 'content',
                        'type' => 'string',
                        'default' => ''
                    ]
                ]
            ],
            'Text' => [
                'label' => Yii::t('contentbuilder', 'Текст'),
                'description' => Yii::t('contentbuilder', 'Текст'),
                'icon' => 'fa fa-file-text-o',
                'class' => 'contentBuilder\widgets\TextWidget',
                'attributes' => [
                    'height' => [
                        'name' => Yii::t('contentbuilder', 'Высота'),
                        'attr' => 'height',
                        'type' => 'string',
                        'default' => '100px'
                    ],
                    'content' => [
                        'name' => Yii::t('contentbuilder', 'Контент'),
                        'attr' => 'content',
                        'type' => 'text',
                        'default' => ''
                    ]
                ]
            ],
            'Image' => [
                'label' => Yii::t('contentbuilder', 'Картинка'),
                'description' => Yii::t('contentbuilder', 'Картинка'),
                'icon' => 'fa fa-file-image-o',
                'class' => 'contentBuilder\widgets\ImageWidget',
                'attributes' => [
                    'url' => [
                        'name' => Yii::t('contentbuilder', 'Ссылка'),
                        'attr' => 'url',
                        'type' => 'image',
                        'default' => ''
                    ],
                    'width' => [
                        'name' => Yii::t('contentbuilder', 'Ширина'),
                        'attr' => 'width',
                        'type' => 'int',
                        'default' => ''
                    ],
                    'height' => [
                        'name' => Yii::t('contentbuilder', 'Высота'),
                        'attr' => 'height',
                        'type' => 'int',
                        'default' => ''
                    ],
                    'title' => [
                        'name' => Yii::t('contentbuilder', 'Заголовок'),
                        'attr' => 'title',
                        'type' => 'string',
                        'default' => ''
                    ],
                    'alt' => [
                        'name' => 'Alt',
                        'attr' => 'alt',
                        'type' => 'string',
                        'default' => ''
                    ],
                    'description' => [
                        'name' => Yii::t('contentbuilder', 'Описание'),
                        'attr' => 'description',
                        'type' => 'string',
                        'default' => ''
                    ]
                ]
            ],
            'Video' => [
                'label' => Yii::t('contentbuilder', 'Видео'),
                'description' => Yii::t('contentbuilder', 'Видео'),
                'icon' => 'fa fa-file-video-o',
                'class' => 'contentBuilder\widgets\VideoWidget',
                'attributes' => [
                    'url-mp4' => [
                        'name' => Yii::t('contentbuilder', 'Ссылка mp4'),
                        'attr' => 'url-mp4',
                        'type' => 'string',
                        'default' => ''
                    ],
                    'url-webm' => [
                        'name' => Yii::t('contentbuilder', 'Ссылка webm'),
                        'attr' => 'url-webm',
                        'type' => 'string',
                        'default' => ''
                    ],
                    'loop' => [
                        'name' => Yii::t('contentbuilder', 'Повторять'),
                        'attr' => 'loop',
                        'type' => 'bool',
                        'default' => false
                    ],
                    'muted' => [
                        'name' => 'Без звука',
                        'attr' => 'muted',
                        'type' => 'bool',
                        'default' => false
                    ],
                    'autoplay' => [
                        'name' => Yii::t('contentbuilder', 'Автовоспроизведение'),
                        'attr' => 'autoplay',
                        'type' => 'bool',
                        'default' => false
                    ],
                    'controls' => [
                        'name' => Yii::t('contentbuilder', 'Управление'),
                        'attr' => 'controls',
                        'type' => 'bool',
                        'default' => true
                    ],
                    'description' => [
                        'name' => Yii::t('contentbuilder', 'Описание'),
                        'attr' => 'description',
                        'type' => 'string',
                        'default' => ''
                    ],
                    'title' => [
                        'name' => Yii::t('contentbuilder', 'Заголовок'),
                        'attr' => 'title',
                        'type' => 'string',
                        'default' => ''
                    ],
                ]
            ],
        ], $this->elements);
    }
}