<?php

namespace WondersLabCorporation\cutter;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonGroup;

/**
 * Class Cutter
 */
class Cutter extends \yii\widgets\InputWidget
{
    /**
     * Image options
     * @var
     */
    public $imageOptions;

    /**
     * Use the height of the current window for the form image cropping
     * @var bool
     */
    public $useWindowHeight = true;
    
    /**
     * Whether to show remove button or not
     * @var bool
     */
    public $showRemoveButton = true;

    /**
     * Cropper options
     * @var array
     */
    public $pluginOptions = [];

    /**
     * Default cropper options
     * @var array
     */
    public $defaultCropperOptions = [
        'rotatable' => true,
        'zoomable' => true,
        'movable' => true,
        'viewMode' => 1,
        'dragMode' => 'move',
        'aspectRatio' => 1,
    ];

    private $view;

    public function init()
    {
        parent::init();

        $this->view = $this->getView();

        AssetBundle::register($this->view);

        $this->pluginOptions = array_merge($this->pluginOptions, $this->defaultCropperOptions);
    }

    public function run()
    {
        return $this->render('cutter', [
            'imageOptions' => $this->imageOptions,
            'useWindowHeight' => $this->useWindowHeight,
            'pluginOptions' => $this->pluginOptions,
            'options' => $this->options,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'showRemoveButton' => $this->showRemoveButton,
        ]);
    }
}