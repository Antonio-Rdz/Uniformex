<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $front;
    /**
     * @var UploadedFile
     */
    public $back;
    /**
     * @var UploadedFile
     */
    public $design;

    public function rules()
    {
        return [
            [['front', 'back', 'design'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif, jpeg, bmp'],
        ];
    }

    public function upload()
    {
        $paths = ['front' => '', 'back' => '', 'design' => ''];
        if ($this->validate()) {
            if($this->front){
                $paths['front'] = $this->getUniqueBaseName() . '.' . $this->front->extension;
                $this->front->saveAs('uploads/' . $paths['front']);
            }
            if($this->back){
                $paths['back'] = $this->getUniqueBaseName(). '.' . $this->back->extension;
                $this->back->saveAs('uploads/' . $paths['back']);
            }
            if($this->design){
                $paths['design'] = $this->getUniqueBaseName() . '.' . $this->design->extension;
                $this->design->saveAs('uploads/' . $paths['design']);
            }
            return $paths;
        } else {
            return false;
        }
    }

    public function getUniqueBaseName(){
        return substr( base_convert( time(), 10, 36 ) . md5( microtime() ), 0, 16 );
    }
}