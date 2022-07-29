<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "juez".
 *
 * @property int $id_juez
 * @property string $nombre_juez
 * @property int $estado_juez
 */
class Juez extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'juez';
    }

    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->nombre_juez = strtoupper($this->nombre_juez);
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_juez'], 'required'],
            [['estado_juez'], 'integer'],
            [['nombre_juez'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_juez' => 'Codigo',
            'nombre_juez' => 'Nombre del juez',
            'estado_juez' => 'Estado',
        ];
    }
    
      public function getValidarjuez()
    {
        if ($this->estado_juez == 0){
            $estado_juez = "SI";
        }else{
            $estado_juez = "NO";
        }
        return $estado_juez;
    }
}
