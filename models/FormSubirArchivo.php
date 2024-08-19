<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Archivodir;
use yii\web\UploadedFile;


class FormSubirArchivo extends Model
{
    public $file;
    public $numero;
    public $codigo;
    public $validador_imagen;
    
    public function rules()
    {
        return [
             ['numero', 'default'],
            ['codigo', 'string'],
            ['validador_imagen', 'default'],
            ['file', 'file',
            'skipOnEmpty' => false,
            'uploadRequired' => 'Debe de seleccionar al menos un acrhivo.',    
            'extensions' => 'jpeg,jpg,png',            
            'wrongExtension' => 'El archivo no contiene una extension permitida.',
            'maxFiles' => 4,
            'tooMany' => 'El maximo de archivos permito son (4)',
        ],
     ];           
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Selecciona el archivo:', 
            'numero' => '',
            'codigo' => '',
            'validador_imagen' => '',
        ];
    }

 
}