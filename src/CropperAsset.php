<?php

namespace WondersLabCorporation\cutter;

/**
 * Class AssetBundle
 * @package sadovojav\cutter
 */
class CropperAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/cropper';
    
    public $js = [
        YII_ENV_DEV ? 'dist/cropper.js' : 'dist/cropper.min.js',
    ];
    
    public $css = [
        YII_ENV_DEV ? 'dist/cropper.css' : 'dist/cropper.min.css',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}