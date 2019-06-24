Yii2 content builder
====================
The module is designed for simplified construction of site pages.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mix8872/yii2-content-builder "*"
```

or add

```
"mix8872/yii2-content-builder": "*"
```

to the require section of your `composer.json` file.

Configuration
-------------

Now in common main config you must configure content builder module like this:

```
'content-builder' => [
    'class' => \mix8872\contentBuilder\Module::class,
    'imageUpload' => [
        'uploadRolesAccess' => ['admin'],
        'uploadUrl' => '/uploads/images',
//                'origResize' => ['height' => 400],
        'sizes' => [200, 500, 1000],
    ],
    'elements' => [
        'Text' => [
            'description' => Yii::t('contentbuilder', 'Текст текст'),
            'attributes' => [
                'height' => [
                    'default' => '200px'
                ]
            ]
        ],
        'Clients' => [
            'label' => 'Клиенты',
            'description' => 'Показ всех клиентов',
            'icon' => 'fa fa-wheelchair',
            'class' => 'common\modules\clients\widget\ClientsWidget',
        ],
        'ProjectSlider' => [
            'label' => 'Слайдер в проекте',
            'description' => 'Слайдер во всю ширину на странице проекта',
            'icon' => 'fa fa-star',
            'class' => 'widget\ProjectSliderWidget',
            'attributes' => [
                'id' => [
                    'name' => Yii::t('contentbuilder', 'Слайдер'),
                    'description' => '',
                    'attr' => 'id',
                    'type' => 'select',
                    'default' => '',
                    'variants' => []
                ]
            ]
        ],
        'CenterText' => [
            'label' => 'Текст посередине',
            'description' => 'Блок с центрированным текстом',
            'icon' => 'fa fa-align-center',
            'class' => 'widget\CenterTextWidget',
            'attributes' => [
                'text' => [
                    'name' => Yii::t('contentbuilder', 'Текст'),
                    'attr' => 'text',
                    'type' => 'text',
                    'default' => ''
                ]
            ]
        ],
        'SendMessage' => [
            'label' => 'Отправка сообщения',
            'description' => 'Блок с текстом и кнопкой отправки сообщения',
            'icon' => 'fa fa-comment',
            'class' => 'widget\SendMessageWidget',
            'attributes' => [
                'text' => [
                    'name' => Yii::t('contentbuilder', 'Текст'),
                    'attr' => 'text',
                    'type' => 'string',
                    'default' => ''
                ],
                'btnText' => [
                    'name' => Yii::t('contentbuilder', 'Текст на кнопке'),
                    'attr' => 'btnText',
                    'type' => 'string',
                    'default' => 'Отправить'
                ]
            ]
        ],
        'ServicesList' => [
            'label' => 'Список услуг',
            'description' => 'Список услуг',
            'icon' => 'fa fa-th',
            'class' => 'widget\ServicesListWidget',
        ],
    ]
],
```

imageUpload section defines image upload parameters and contains the following parameters:

* _uploadRolesAccess_ - **required** - an array of roles that are allowed to upload images to content builder
* _uploadUrl_ - **required** - the path from the web folder
* _origResize_ - **optional** - if you need to resize original uploaded images. Height, width or both can be defined in px
* _sizes_ - **optional,** **don't work now** - array of dimensions by width which will append to img tag by srcset

Elements section contains the array of widgets and their parameters those should be display in frontend.
As defult in module defined 4 widgets with such config:

```
'Header' => [
    'label' => Yii::t('contentbuilder', 'Заголовок'),
    'description' => Yii::t('contentbuilder', 'Заголовок'),
    'icon' => 'fa fa-header',
    'class' => 'mix8872\contentBuilder\widgets\frontend\HeaderWidget',
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
    'class' => 'mix8872\contentBuilder\widgets\frontend\TextWidget',
    'attributes' => [
        'height' => [
            'name' => Yii::t('contentbuilder', 'Высота'),
            'attr' => 'height',
            'type' => 'string',
            'default' => ''
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
    'class' => 'mix8872\contentBuilder\widgets\frontend\ImageWidget',
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
    'class' => 'mix8872\contentBuilder\widgets\frontend\VideoWidget',
    'attributes' => [
        'urlMp4' => [
            'name' => Yii::t('contentbuilder', 'Ссылка mp4'),
            'attr' => 'url-mp4',
            'type' => 'string',
            'default' => ''
        ],
        'urlWebm' => [
            'name' => Yii::t('contentbuilder', 'Ссылка webm'),
            'attr' => 'url-webm',
            'type' => 'string',
            'default' => ''
        ],
        'poster' => [
            'name' => Yii::t('contentbuilder', 'Постер'),
            'attr' => 'url',
            'type' => 'image',
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
```

This config can be overridden in the module configuration like this:
```
'Text' => [
    'description' => Yii::t('contentbuilder', 'Текст текст'),
    'attributes' => [
        'height' => [
            'default' => '200px'
        ]
    ]
],
```

Also you can add you custom random widgets with their parameters that will be passed to the widget when it is initialized.
An example of adding is shown above.

Widget attributes can be of the following types:

* string, example:
```
'title' => [
   'name' => Yii::t('contentbuilder', 'Заголовок'),
   'attr' => 'title',
   'type' => 'string',
   'default' => ''
],
```
* text, example:
```
'description' => [
    'name' => Yii::t('contentbuilder', 'Описание'),
    'attr' => 'text',
    'type' => 'text',
    'default' => ''
]
```
* select, example:
```
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
```
* int, example:
```
'width' => [
    'name' => Yii::t('contentbuilder', 'Ширина'),
    'attr' => 'width',
    'type' => 'int',
    'default' => ''
],
```
* bool, checkbox, example:
```
'muted' => [
    'name' => 'Без звука',
    'attr' => 'muted',
    'type' => 'bool',
    'default' => false
],
```
* image, uploads images and save its by config from imageUpload section, stores url for uploaded image, example:
```
'url' => [
    'name' => Yii::t('contentbuilder', 'Ссылка'),
    'attr' => 'url',
    'type' => 'image',
    'default' => ''
],
```
* color, colorpicker, example:
```
'mainColor' => [
    'name' => 'Основной цвет',
    'attr' => 'mainColor',
    'type' => 'color',
    'default' => '#ffaa11'
],
```

Also class (_className_) and ID (_htmlId_) variables are defined for each widget, so you can define this properties in you widget class and use their.

Usage
-----

Once the extension is installed, simply use it in your code by  :

```
use mix8872\contentBuilder\widgets\backend\ContentBuilder;

...

<?= $form->field($model, 'some_text_field')->widget(ContentBuilder::class) ?>

...

```

For get HTML content on frontend side you can use \mix8872\contentBuilder\components\ContentParser class and its method parse(array $data) like this:
```
$html = (new ContentParser)->parse($model->content);
```