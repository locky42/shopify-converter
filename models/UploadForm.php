<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\helpers\File;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public UploadedFile $file;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }

    /**
     * @return bool
     */
    public function upload(): bool
    {
        if ($this->validate()) {
            $this->file->saveAs(File::getFilePath($this->file->baseName . '.' . $this->file->extension));
            return true;
        } else {
            return false;
        }
    }
}
