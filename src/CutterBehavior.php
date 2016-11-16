<?php

namespace WondersLabCorporation\cutter;

use Imagine\Image\Palette\Color\RGB;
use Imagine\Imagick\Imagine;
use Yii;
use yii\helpers\Json;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class CutterBehavior
 * @package sadovojav\cutter\behavior
 */
class CutterBehavior extends \yii\behaviors\AttributeBehavior
{
    /**
     * Attributes
     * @var
     */
    public $attributes;

    /**
     * Base directory
     * @var
     */
    public $baseDir;

    /**
     * Base path
     * @var
     */
    public $basePath;

    /**
     * Image cut quality
     * @var int
     */
    public $quality = 92;

    /**
     * Whether to use transparent background for new image or not. Defaults to true
     * @var
     */
    public $transparentBackground = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeUpload',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpload',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeValidate()
    {
        if (is_array($this->attributes) && count($this->attributes)) {
            foreach ($this->attributes as $attribute) {
                $this->createInstance($attribute);
            }
        } else {
            $this->createInstance($this->attributes);
        }
    }

    public function afterValidate()
    {
        if (is_array($this->attributes) && count($this->attributes)) {
            foreach ($this->attributes as $attribute) {
                $this->revertAttribute($attribute);
            }
        } else {
            $this->revertAttribute($this->attributes);
        }
    }

    public function revertAttribute($attribute)
    {
        // Reverting old attribute value to show old image in preview when some error occurred on backend
        if ($this->owner->hasErrors()) {
            $this->owner->{$attribute} = isset($this->owner->oldAttributes[$attribute]) ? $this->owner->oldAttributes[$attribute] : null;
        }
    }

    public function createInstance($attribute)
    {
        $this->owner->{$attribute} = UploadedFile::getInstance($this->owner, $attribute);
    }

    public function beforeUpload()
    {
        if (is_array($this->attributes) && count($this->attributes)) {
            foreach ($this->attributes as $attribute) {
                $this->upload($attribute);
            }
        } else {
            $this->upload($this->attributes);
        }
    }

    public function upload($attribute)
    {
        $uploadImage = $this->owner->{$attribute};
        if ($uploadImage instanceof UploadedFile) {
            if (!$this->owner->isNewRecord) {
                $this->delete($attribute);
            }
            $defaults = [
                'dataRotate' => null,
                'dataX' => null,
                'dataY' => null,
                'dataWidth' => null,
                'dataHeight' => null,
            ];
            $ownerPost = Yii::$app->request->post($this->owner->formName());
            $jsonCroppingData = isset($ownerPost[$attribute . '-cropping-data']) ? $ownerPost[$attribute . '-cropping-data'] : $defaults;
            $cropping = Json::decode($jsonCroppingData);

            $croppingFileName = md5($uploadImage->name . $this->quality . $jsonCroppingData);
            $croppingFileExt = strrchr($uploadImage->name, '.');
            $croppingFileDir = substr($croppingFileName, 0, 2);

            $croppingFileBasePath = Yii::getAlias($this->basePath) . $this->baseDir;

            if (!is_dir($croppingFileBasePath)) {
                mkdir($croppingFileBasePath, 0755, true);
            }

            $croppingFilePath = Yii::getAlias($this->basePath) . $this->baseDir . DIRECTORY_SEPARATOR . $croppingFileDir;

            if (!is_dir($croppingFilePath)) {
                mkdir($croppingFilePath, 0755, true);
            }

            $croppingFile = $croppingFilePath . DIRECTORY_SEPARATOR . $croppingFileName . $croppingFileExt;

            $imageTmp = Image::getImagine()->open($uploadImage->tempName);
            $imageTmp->rotate($cropping['dataRotate']);

            if (Image::getImagine() instanceof Imagine && $this->transparentBackground) {
                // Hotfix for Imagine with transparent background
                $image = Image::getImagine()->create($imageTmp->getSize(), new RGB(new \Imagine\Image\Palette\RGB(), [0, 0, 0], 0));
            } else {
                $image = Image::getImagine()->create($imageTmp->getSize());
            }
            $image->paste($imageTmp, new Point(0, 0));

            $point = new Point($cropping['dataX'], $cropping['dataY']);
            $box = new Box($cropping['dataWidth'], $cropping['dataHeight']);

            $image->crop($point, $box);
            $image->save($croppingFile, ['quality' => $this->quality]);

            $this->owner->{$attribute} = $this->baseDir . DIRECTORY_SEPARATOR . $croppingFileDir
                . DIRECTORY_SEPARATOR . $croppingFileName . $croppingFileExt;
        } elseif (isset($_POST[$attribute . '-remove']) && $_POST[$attribute . '-remove']) {
            $this->delete($attribute);
        } elseif (isset($this->owner->oldAttributes[$attribute])) {
            $this->owner->{$attribute} = $this->owner->oldAttributes[$attribute];
        }
    }

    public function beforeDelete()
    {
        if (is_array($this->attributes) && count($this->attributes)) {
            foreach ($this->attributes as $attribute) {
                $this->delete($attribute);
            }
        } else {
            $this->delete($this->attributes);
        }
    }

    public function delete($attribute)
    {
        $file = Yii::getAlias($this->basePath) . $this->owner->oldAttributes[$attribute];

        if (is_file($file) && file_exists($file)) {
            unlink(Yii::getAlias($this->basePath) . $this->owner->oldAttributes[$attribute]);
        }
    }
}
