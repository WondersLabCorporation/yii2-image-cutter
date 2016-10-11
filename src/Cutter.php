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
     * Cropper buttons template
     * @var
     */
    public $cropperButtonsTemplate = '<div class="btn-toolbar pull-left">{zoomIn} {zoomOut} {rotateLeft} {rotateRight} {refresh}</div>';

    /**
     * Cropper buttons
     * @var
     */
    public $cropperButtons = [];

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
    ];

    private $view;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->view = $this->getView();

        AssetBundle::register($this->view);

        // Merge provided plugin options with the default ones
        $this->pluginOptions = array_merge($this->pluginOptions, $this->defaultCropperOptions);

        $this->initDefaultCropperButtons();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('cutter', [
            'imageOptions' => $this->imageOptions,
            'useWindowHeight' => $this->useWindowHeight,
            'pluginOptions' => $this->pluginOptions,
            'options' => $this->options,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'value' => Html::getAttributeValue($this->model, $this->attribute),
            'showRemoveButton' => $this->showRemoveButton,
            'cropperButtons' => $this->getCropperButtons(),
        ]);
    }

    /**
     * @return string Generate cropper buttons HTML string
     */
    protected function getCropperButtons()
    {
        $result = $this->cropperButtonsTemplate;
        foreach ($this->cropperButtons as $key => $cropperButton) {
            $result = str_replace('{' . $key . '}', $cropperButton, $result);
        }
        return $result;
    }

    /**
     * Init default buttons for cropper
     */
    protected function initDefaultCropperButtons()
    {
        if (!isset($this->cropperButtons['rotateLeft'])) {
            $this->cropperButtons['rotateLeft'] = Html::a(
                '<i class="glyphicon glyphicon-share-alt icon-flipped"></i>',
                '#',
                [
                    'type' => 'button',
                    'data-method' => 'rotate',
                    'data-option' => '45',
                    'class' => 'btn btn-primary',
                    'title' => Yii::t('WondersLabCorporation/cutter', 'Rotate left'),
                ]
            );
        }

        if (!isset($this->cropperButtons['rotateRight'])) {
            $this->cropperButtons['rotateRight'] = Html::a(
                '<i class="glyphicon glyphicon-share-alt"></i>',
                '#',
                [
                    'type' => 'button',
                    'data-method' => 'rotate',
                    'data-option' => '-45',
                    'class' => 'btn btn-primary',
                    'title' => Yii::t('WondersLabCorporation/cutter', 'Rotate right'),
                ]
            );
        }

        if (!isset($this->cropperButtons['zoomIn'])) {
            $this->cropperButtons['zoomIn'] = Html::a(
                '<i class="glyphicon glyphicon-zoom-in"></i>',
                '#',
                [
                    'type' => 'button',
                    'data-method' => 'zoom',
                    'data-option' => '0.1',
                    'class' => 'btn btn-primary',
                    'title' => Yii::t('WondersLabCorporation/cutter', 'Zoom In'),
                ]
            );
        }
        if (!isset($this->cropperButtons['zoomOut'])) {
            $this->cropperButtons['zoomOut'] = Html::a(
                '<i class="glyphicon glyphicon-zoom-out"></i>',
                '#',
                [
                    'type' => 'button',
                    'data-method' => 'zoom',
                    'data-option' => '-0.1',
                    'class' => 'btn btn-primary',
                    'title' => Yii::t('WondersLabCorporation/cutter', 'Zoom Out'),
                ]
            );
        }
        if (!isset($this->cropperButtons['refresh'])) {
            $this->cropperButtons['refresh'] = Html::a(
                '<i class="glyphicon glyphicon-refresh"></i>',
                '#',
                [
                    'type' => 'button',
                    'data-method' => 'reset',
                    'class' => 'btn btn-primary',
                    'title' => Yii::t('WondersLabCorporation/cutter', 'Refresh'),
                ]
            );
        }
    }
}