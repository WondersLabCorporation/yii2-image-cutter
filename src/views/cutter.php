<?php

/* @var $this \yii\web\View */
/* @var $model \yii\db\ActiveRecord */
/* @var $attribute string */
/* @var $imageOptions array */
/* @var $pluginOptions array */
/* @var $useWindowHeight boolean */
/* @var $showRemoveButton boolean */
/* @var $cropperButtons string */

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

$this->registerJs('jQuery("#' . $inputField . '").cutter(' . Json::encode([
        'attribute' => $attribute,
        'inputField' => $inputField,
        'useWindowHeight' => $useWindowHeight,
        'cropperOptions' => $pluginOptions
    ]) . ');');
?>
<div class="image-cutter" id="<?= $inputField . '-cutter'; ?>">
    <?= Html::activeFileInput($model, $attribute); ?>
    <?= Html::hiddenInput($attribute . '-cropping-data', '{}'); ?>
    <label class="dropzone" for="<?= $inputField ?>">
        <span class="img-container">
            <span><?= Yii::t('WondersLabCorporation/cutter', 'Click to upload image'); ?></span>
            <?= Html::img($model->$attribute ? $model->$attribute : null, [
                'class' => 'preview-image',
            ]); ?>
        </span>
    </label>
    <?php if ($showRemoveButton) : ?>
    <?= Html::checkbox($attribute . '-remove', false, [
        'label' => Yii::t('WondersLabCorporation/cutter', 'Remove')
    ]); ?>
    <?php endif; ?>

    <?php Modal::begin([
        'header' => Html::tag('h4', Yii::t('WondersLabCorporation/cutter', 'Cutter'), ['class' => 'modal-title']),
        'closeButton' => false,
        'size' => Modal::SIZE_LARGE,
        'footer' => <<<FOOTER
{$cropperButtons}
<a class="btn btn-danger" id="{$imageOptions['id']}_button_cancel">Cancel</a>
<a class="btn btn-success" id="{$imageOptions['id']}_button_accept">Accept</a>
FOOTER
        ,
    ]); ?>

    <div class="image-container">
        <?= Html::img(null, $imageOptions); ?>
    </div>
    <?php Modal::end(); ?>
</div>
