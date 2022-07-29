<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Archivodir;
use yii\web\UploadedFile;


class FormSubirArchivo extends Model
{
    public $imageFile;
    public $numero;
    public $codigo;
    public $view;
    
    public function rules()
    {
        return [
            [['imageFile'], 'required', 'message' => 'Campo requerido'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],            
            ['numero', 'default'],
            ['codigo', 'default'],
            ['view', 'default'],
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Archivo:',            
            'numero' => '',
            'codigo' => '',
            'view' => '',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $carpeta = 'Documentos/'.$this->numero.'/'.$this->codigo.'/';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            if(!file_exists($carpeta . $this->imageFile->baseName . '.' . $this->imageFile->extension)){
                $this->imageFile->saveAs($carpeta . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
            }else{
                return false;
            }
            
        } else {
            return false;
        }
    }
}