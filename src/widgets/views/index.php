<?php

\mix8872\contentBuilder\assets\ContentBuilderAsset::register($this);

use yii\helpers\Html;
use yii\helpers\StringHelper;

$baseClass = StringHelper::basename(get_class($model));

$configJson = json_encode($config);

$this->registerJS('
    window.contentBuilder_' . $rootId . ' = {
        outputFieldName: "' . $baseClass . preg_replace("/^(\[\w+\])(\w+)/ui", "\$1[$2]", $attribute) . '",
        sections: ' . $model->content . ',
        elementsConfig: ' . json_encode($config) . ',
        uploadsUrl: "/sdfdn/"
    };

    $(document).ready(function(){ 
        window.startReact("' . $rootId . '");
    });
', $this::POS_END);

?>
<?= Html::activeHiddenInput($model, $attribute) ?>
<div id="<?= $rootId ?>"></div>