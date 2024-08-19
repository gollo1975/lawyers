<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "directorio_archivos".
 *
 * @property int $idarchivodir
 * @property int $iddocumentodir
 * @property string $fecha_creacion
 * @property int $numero
 * @property int $iddirectorio
 * @property string $codigo
 * @property string $nombre
 * @property string $extension
 * @property string $tipo
 * @property double $tamaño
 * @property string $descripcion
 * @property string $comentarios
 * @property int $predeterminado
 *
 * @property Documentodir $documentodir
 * @property Directorio $directorio
 */
class DirectorioArchivos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'directorio_archivos';
    }
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->descripcion = strtoupper($this->descripcion);                
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iddocumentodir', 'numero', 'iddirectorio','predeterminado'], 'integer'],
            [['fecha_creacion'], 'safe'],
            [['tamaño'], 'number'],
            [['descripcion', 'comentarios'], 'string'],
            [['codigo'], 'string', 'max' => 20],
            [['nombre'], 'string', 'max' => 200],
            [['extension', 'tipo'], 'string', 'max' => 50],
            [['iddocumentodir'], 'exist', 'skipOnError' => true, 'targetClass' => Documentodir::className(), 'targetAttribute' => ['iddocumentodir' => 'iddocumentodir']],
            [['iddirectorio'], 'exist', 'skipOnError' => true, 'targetClass' => Directorio::className(), 'targetAttribute' => ['iddirectorio' => 'iddirectorio']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idarchivodir' => 'Idarchivodir',
            'iddocumentodir' => 'Iddocumentodir',
            'fecha_creacion' => 'Fecha Creacion',
            'numero' => 'Numero',
            'iddirectorio' => 'Iddirectorio',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'extension' => 'Extension',
            'tipo' => 'Tipo',
            'tamaño' => 'Tamaño',
            'descripcion' => 'Descripcion',
            'comentarios' => 'Comentarios',
            'predeterminado' => 'Predeterminado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentodir()
    {
        return $this->hasOne(Documentodir::className(), ['iddocumentodir' => 'iddocumentodir']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirectorio()
    {
        return $this->hasOne(Directorio::className(), ['iddirectorio' => 'iddirectorio']);
    }
    
    public function getImagenActiva() {
       if($this->predeterminado == 0){
           $imagenActiva = 'NO';
       } else{
           $imagenActiva = 'SI';
       }
       return $imagenActiva;
    }
}
