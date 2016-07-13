<?php

namespace WondersLabCorporation\cutter;

/**
 * Class AssetBundle
 * @package sadovojav\cutter
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $js = [
        'js/cutter.js',
    ];
    public $css = [
        'css/cutter.css',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
        'WondersLabCorporation\cutter\CropperAsset',
    ];

    public function init()
    {
        $this->sourcePath = dirname(__DIR__) . '/assets';
        parent::init();
    }
}