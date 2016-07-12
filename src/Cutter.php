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
     * Cropper options
     * @var array
     */
    public $cropperOptions = [];

    /**
     * Default cropper options
     * @var array
     */
    public $defaultCropperOptions = [
        'rotatable' => true,
        'zoomable' => true,
        'movable' => true,
    ];

    private $view;

    public function init()
    {
        parent::init();

        $this->view = $this->getView();

        AssetBundle::register($this->view);

        $this->cropperOptions = array_merge($this->cropperOptions, $this->defaultCropperOptions);
    }

    public function run()
    {
        return $this->render('cutter', [
            'imageOptions' => $this->imageOptions,
            'useWindowHeight' => $this->useWindowHeight,
            'cropperOptions' => $this->cropperOptions,
            'options' => $this->options,
            'model' => $this->model,
            'attribute' => $this->attribute,
        ]);
    }
}