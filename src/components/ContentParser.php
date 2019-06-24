<?php
/**
 * Created by PhpStorm.
 * User: Mix
 * Date: 05.06.2018
 * Time: 10:31
 */

namespace mix8872\contentBuilder\components;

use Yii;
use DOMDocument;
use yii\base\Widget;

class ContentParser
{
    protected $modeule;
    protected $elements;
    protected $dom;

    public function __construct()
    {
        $this->module = Yii::$app->getModule('content-builder');
        $this->dom = new DOMDocument();
    }

    public function parse(string $dataString)
    {
        try {
            $data = json_decode($dataString);
        } catch (\Exception $e) {
            error_log('Current string is not valid JSON');
            return null;
        }

        if (!is_array($data)) {
            return null;
        }

        if (!$this->_validate($data)) {
            error_log('Current data is not valid contentBuilder data');
            return null;
        }

        foreach ($data as $sectionData) {
            $section = $this->_makeSection($sectionData);
            $container = $this->_makeContainer($sectionData);
            if (!$section || !$container) {
                continue;
            }
            foreach ($sectionData->rows as $rowData) {
                $row = $this->_makeRow($rowData);
                if (!$row) {
                    continue;
                }
                foreach ($rowData->cols as $colData) {
                    $col = $this->_makeCol($colData);
                    if (!$col) {
                        continue;
                    }
                    foreach ($colData->items as $itemData) {
                        $item = $this->_makeItem($itemData);
                        if (!$item) {
                            continue;
                        }
                        $col->appendChild($item);
                    }
                    $row->appendChild($col);
                }
                $container->appendChild($row);
            }
            $section->appendChild($container);
            $this->dom->appendChild($section);
        }
        return html_entity_decode($this->dom->saveHTML());
    }

    protected function _validate($data)
    {
        foreach ($data as $sectionData) {
            switch (false) {
                case $sectionData instanceof \stdClass:
                case property_exists($sectionData, 'sectionId'):
                case property_exists($sectionData, 'sectionClassName'):
                case property_exists($sectionData, 'containerClassName'):
                case property_exists($sectionData, 'bgColor'):
                case property_exists($sectionData, 'bgImg'):
                case property_exists($sectionData, 'isFluid'):
                case property_exists($sectionData, 'noPadding'):
                case property_exists($sectionData, 'rows'):
                    return false;
            }
            foreach ($sectionData->rows as $rowData) {
                switch (false) {
                    case $rowData instanceof \stdClass:
                    case property_exists($rowData, 'className'):
                    case property_exists($rowData, 'cols'):
                    return false;
                }
                foreach ($rowData->cols as $colData) {
                    switch (false) {
                        case $colData instanceof \stdClass:
                        case property_exists($colData, 'className'):
                        case property_exists($colData, 'items'):
                            return false;
                    }
                    foreach ($colData->items as $itemData) {
                        switch (false) {
                            case $itemData instanceof \stdClass:
                            case property_exists($itemData, 'className'):
                            case property_exists($itemData, 'htmlId'):
                                return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    protected function _makeSection($sectionData)
    {
        if ($sectionData instanceof \stdClass) {
            $section = $this->dom->createElement('section');
            if ($sectionData->sectionId) {
                $section->setAttribute('id', $sectionData->sectionId);
            }
            if ($sectionData->sectionClassName) {
                $section->setAttribute('class', $sectionData->sectionClassName);
            }
            $sectionStyle = '';
            if ($sectionData->bgColor) {
                $sectionStyle .= "background-color:{$sectionData->bgColor}";
            }
            if ($sectionData->bgImg) {
                $sectionStyle .= "background-image:url($sectionData->bgImg)";
            }
            if ($sectionStyle) {
                $section->setAttribute('style', $sectionStyle);
            }
            return $section;
        }
        return null;
    }

    protected function _makeContainer($sectionData)
    {
        if ($sectionData instanceof \stdClass) {
            $container = $this->dom->createElement('div');
            $containerClass = $sectionData->isFluid ? 'container-fluid' : 'container';
            $sectionData->containerClassName
                ? $container->setAttribute('class', "$containerClass " . $sectionData->containerClassName)
                : $container->setAttribute('class', $containerClass);
            if ($sectionData->noPadding) {
                $container->setAttribute('style', 'padding: 0');
            }
            return $container;
        }
        return null;
    }

    protected function _makeRow($rowData)
    {
        if ($rowData instanceof \stdClass) {
            $row = $this->dom->createElement('div');
            $rowData->className
                ? $row->setAttribute('class', 'row ' . $rowData->className)
                : $row->setAttribute('class', 'row');
            return $row;
        }
        return null;
    }

    protected function _makeCol($colData)
    {
        if ($colData instanceof \stdClass) {
            $col = $this->dom->createElement('div');
            $colClassNames = [];
            foreach (get_object_vars($colData) as $colAttrName => $colAttrVal) {
                if ($colAttrName !== 'id' && is_int($colAttrVal) && $colAttrVal !== -1) {
                    if (strpos($colAttrName, 'offset') === false) {
                        $colClassNames[] = 'col' . ($colAttrName !== 'xs' ? "-$colAttrName" : '') . ($colAttrVal !== 0 ? "-$colAttrVal" : '');
                    } else {
                        $colAttrName = strtolower(str_replace('offset', '', $colAttrName));
                        $colClassNames[] = 'offset' . ($colAttrName !== 'xs' ? "-$colAttrName" : '') . "-$colAttrVal";
                    }
                }
            }
            if (!$colClassNames) {
                $colClassNames[] = 'col-12';
            }
            if ($colData->className) {
                $colClassNames[] = $colData->className;
            }
            $col->setAttribute('class', implode(' ', $colClassNames));
            return $col;
        }
        return null;
    }

    protected function _makeItem($itemData)
    {
        if ($itemData instanceof \stdClass) {
            if (array_key_exists($itemData->class, $this->module->elements)) {
                $itemConfig = $this->module->elements[$itemData->class];
                if (class_exists($itemConfig['class'])) {
                    $widget = new $itemConfig['class']();
                    if ($widget instanceof Widget) {
                        if (isset($itemData->attributes)) {
                            $widgetConfig = array_merge([
                                'className' => $itemData->className,
                                'htmlId' => $itemData->htmlId
                            ], (array)$itemData->attributes);
                        } else {
                            $widgetConfig = [
                                'className' => $itemData->className,
                                'htmlId' => $itemData->htmlId
                            ];
                        }
                        foreach ($widgetConfig as $wConfName => $wConfValue) {
                            if (!$widget->hasProperty($wConfName)) {
                                unset($widgetConfig[$wConfName]);
                            }
                        }
                        $item = $this->dom->createTextNode($widget::widget($widgetConfig));
                        return $item;
                    }
                }
            }
        }
        return null;
    }
}