<?php

/* @var $this \yii\web\View */
/* @var $cropperOptions array */
/* @var $inputField string */
/* @var $imageOptions array */

use yii\bootstrap\ButtonGroup;

?>
<div class="btn-toolbar pull-left">
    <?= ButtonGroup::widget([
    'encodeLabels' => false,
    'buttons' => [
    [
    'label' => '<i class="glyphicon glyphicon-move"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'setDragMode',
    'data-option' => 'move',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Drag mode "move"'),
    ]
    ],
    [
    'label' => '<i class="glyphicon glyphicon-scissors"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'setDragMode',
    'data-option' => 'crop',
    'class' => 'btn btn-primary',
    'data-title' => Yii::t('WondersLabCorporation/cutter', 'Drag mode "crop"'),
    ]
    ],
    ],
    'options' => [
    'class' => 'pull-left'
    ]
    ]) .
    ButtonGroup::widget([
    'encodeLabels' => false,
    'buttons' => [
    [
    'label' => '<i class="glyphicon glyphicon-ok"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'crop',
    'class' => 'btn btn-primary',
    'data-title' => Yii::t('WondersLabCorporation/cutter', 'Crop'),
    ]
    ],
    [
    'label' => '<i class="glyphicon glyphicon-refresh"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'reset',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Refresh'),
    ]
    ],
    [
    'label' => '<i class="glyphicon glyphicon-remove"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'clear',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Remove'),
    ]
    ],
    ],
    'options' => [
    'class' => 'pull-left'
    ]
    ]) .
    ButtonGroup::widget([
    'encodeLabels' => false,
    'buttons' => [
    [
    'label' => '<i class="glyphicon glyphicon-zoom-in"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'zoom',
    'data-option' => '0.1',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Zoom In'),
    ],
    'visible' => $cropperOptions['zoomable']
    ],
    [
    'label' => '<i class="glyphicon glyphicon-zoom-out"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'zoom',
    'data-option' => '-0.1',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Zoom Out'),
    ],
    'visible' => $cropperOptions['zoomable']
    ],
    [
    'label' => '<i class="glyphicon glyphicon-share-alt  icon-flipped"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'rotate',
    'data-option' => '45',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Rotate left'),
    ],
    'visible' => $cropperOptions['rotatable']
    ],
    [
    'label' => '<i class="glyphicon glyphicon-share-alt"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'rotate',
    'data-option' => '-45',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Rotate right'),
    ],
    'visible' => $cropperOptions['rotatable']
    ],
    ],
    'options' => [
    'class' => 'pull-left'
    ]
    ]) .
    ButtonGroup::widget([
    'encodeLabels' => false,
    'buttons' => [
    [
    'label' => '<i class="glyphicon glyphicon-glyphicon glyphicon-resize-full"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'setAspectRatio',
    'data-target' => '#' . $inputField . '-aspectRatio',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Set aspect ratio'),
    ]
    ],
    [
    'label' => '<i class="glyphicon glyphicon-upload"></i>',
    'options' => [
    'type' => 'button',
    'data-method' => 'setData',
    'class' => 'btn btn-primary',
    'title' => Yii::t('WondersLabCorporation/cutter', 'Set data'),
    ]
    ],
    ],
    'options' => [
    'class' => 'pull-left'
    ]
    ]) ?>
</div>
<a class="btn btn-danger" id="<?= $imageOptions['id'] . '_button_cancel' ?>"><?= Yii::t('WondersLabCorporation/cutter', 'Cancel'); ?></a>
<a class="btn btn-success" id="<?= $imageOptions['id'] . '_button_accept' ?>"><?= Yii::t('WondersLabCorporation/cutter', 'Accept'); ?></a>