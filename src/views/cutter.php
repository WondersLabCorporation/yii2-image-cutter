<?php

/* @var $this \yii\web\View */
/* @var $model \yii\db\ActiveRecord */
/* @var $attribute string */
/* @var $imageOptions array */
/* @var $cropperOptions array */
/* @var $useWindowHeight boolean */

use yii\bootstrap\ButtonGroup;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Json;

if (is_null($imageOptions)) {
    $imageOptions = [
        'class' => 'img-responsive',
    ];
}

$imageOptions['id'] = Yii::$app->getSecurity()->generateRandomString(10);

$inputField = Html::getInputId($model, $attribute);

$options = [
    'inputField' => $inputField,
    'useWindowHeight' => $useWindowHeight,
    'cropperOptions' => $cropperOptions
];

$this->registerJs('jQuery("#' . $inputField . '").cutter(' . Json::encode($options) . ');');
?>
<div class="image-cutter" id="<?= $inputField . '-cutter'; ?>">
    <?= Html::activeFileInput($model, $attribute); ?>
    <label class="dropzone" for="<?= $inputField ?>">
        <span class="img-container">
            <span><?= Yii::t('WondersLabCorporation/cutter', 'Click to upload image'); ?></span>
            <?= Html::img($model->$attribute ? $model->$attribute : null, [
                'class' => 'preview-image',
            ]); ?>
        </span>
    </label>
    <?= Html::checkbox($attribute . '-remove', false, [
        'label' => Yii::t('WondersLabCorporation/cutter', 'Remove')
    ]); ?>

    <?php Modal::begin([
        'header' => Html::tag('h4', Yii::t('WondersLabCorporation/cutter', 'Cutter'), ['class' => 'modal-title']),
        'closeButton' => false,
        'size' => Modal::SIZE_LARGE,
        'footer' => $this->render('_modalFooter', [
            'cropperOptions' => $cropperOptions,
            'inputField' => $inputField,
            'imageOptions' => $imageOptions,
        ]),
    ]); ?>

    <div class="image-container">
        <?= Html::img(null, $imageOptions); ?>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-2">
            <?= Html::label(Yii::t('WondersLabCorporation/cutter', 'Aspect ratio'), $inputField . '-aspectRatio'); ?>
            <?= Html::textInput($attribute . '-aspectRatio', isset($cropperOptions['aspectRatio']) ? $cropperOptions['aspectRatio'] : 0, ['id' => $inputField . '-aspectRatio', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-2">
            <?= Html::label(Yii::t('WondersLabCorporation/cutter', 'Angle'), $inputField . '-dataRotate'); ?>
            <?= Html::textInput($attribute . '-cropping[dataRotate]', '', ['id' => $inputField . '-dataRotate', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-2">
            <?= Html::label(Yii::t('WondersLabCorporation/cutter', 'Position') . ' (x)', $inputField . '-dataX'); ?>
            <?= Html::textInput($attribute . '-cropping[dataX]', '', ['id' => $inputField . '-dataX', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-2">
            <?= Html::label(Yii::t('WondersLabCorporation/cutter', 'Position') . ' (y)', $inputField . '-dataY'); ?>
            <?= Html::textInput($attribute . '-cropping[dataY]', '', ['id' => $inputField . '-dataY', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-2">
            <?= Html::label(Yii::t('WondersLabCorporation/cutter', 'Width'), $inputField . '-dataWidth'); ?>
            <?= Html::textInput($attribute . '-cropping[dataWidth]', '', ['id' => $inputField . '-dataWidth', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-2">
            <?= Html::label(Yii::t('WondersLabCorporation/cutter', 'Height'), $inputField . '-dataHeight'); ?>
            <?= Html::textInput($attribute . '-cropping[dataHeight]', '', ['id' => $inputField . '-dataHeight', 'class' => 'form-control']); ?>
        </div>
    </div>
    <?php Modal::end(); ?>
</div>
