<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tallas".
 *
 * @property int $id_talla
 * @property string $nombre_talla
 */
class Tallas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tallas';
    }
     public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->nombre_talla = strtoupper($this->nombre_talla);
	
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_talla'], 'required'],
            [['nombre_talla'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_talla' => 'Codigo',
            'nombre_talla' => 'Nombre de la talla',
        ];
    }
}
