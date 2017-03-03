<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\UploadedFile;

/**
 * This is the form model class for table "uploaded_file".
 */
class UploadedFileForm extends UploadedFile
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          /* filter */
          /* default value */
          /* required */
          /* safe */
          /* field type */
          /* value limitation */
          /* value references */
          [['filename'], 'string'],
          [['size'], 'integer'],
          [['name'], 'string', 'max' => 255],
          [['type'], 'string', 'max' => 64],
        ];
    }

}
