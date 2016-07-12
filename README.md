# Yii2 image cutter

This is a fork [sadovojav/yii2-image-cutter](https://github.com/sadovojav/yii2-image-cutter)

#### Features:
- Upload image
- Crop image
- Use Imagine
- Cache sorting to subdirectories

![cutter](https://cloud.githubusercontent.com/assets/9282021/8411519/fd601b0e-1e8c-11e5-83a5-1f8c4195f562.jpg)

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Add to your `composer.json` file

```json
"repositories": [
    {
        "url": "https://github.com/WondersLabCorporation/yii2-image-cutter.git",
        "type": "git"
    }
]
```
and run

```
composer require WondersLabCorporation/yii2-image-cutter:"dev-master"
```


Usage
------------

* Add to the model behavior

```php
    use WondersLabCorporation\cutter\behaviors\CutterBehavior;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => CutterBehavior::className(),
                'attributes' => 'image',
                // 'attributes' => ['image1', 'image2'],
                'baseDir' => '/uploads/crop',
                'basePath' => '@webroot',
            ],
        ]
    }
    
    public function rules()
    {
        return [
            ['image', 'file', 'extensions' => 'jpg, jpeg, png', 'mimeTypes' => 'image/jpeg, image/png'],
        ];
    }
```

#### Parameters
- integer `attributes` required (string/array) - Image attributes
- integer `baseDir` required - Base directory
- integer `basePath` required - Base path
- integer `quality` =  `92` - Crop result quality

* Use in view
> Without client validation

```php
    <div class="form-group">
        <label class="control-label">Image</label>
        <?= \WondersLabCorporation\cutter\Cutter::widget([
            'model' => $model,
            'attribute' => 'image'
        ]); ?>
    </div>
```

or

> With client validation

```php
    <?= $form->field($model, 'image')->widget(\WondersLabCorporation\cutter\Cutter::className(), [
        //options
    ]); ?>
```

## Widget method options

* model (string) (obligatory)
> Defines the model that will be used to make the form input field.

* attribute (string) (obligatory)
> Defines the model attribute that will be used to make de form input field.

* useWindowHeight (bool) (optional)
> Use the height of the current window for the form image cropping

* imageOptions (array) (optional)
> List with options that will be added to the image field that will be used to define the crop data in the modal. The format should be ['option' => 'value'].

* cropperOptions (array) (optional)
> List with options that will be added in javaScript while creating the crop object. For more information about which options can be added you can [read this web](https://github.com/fengyuanchen/cropper#options).