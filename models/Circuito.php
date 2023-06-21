<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "circuito".
 *
 * @property int $id_circuito
 * @property string $nombre_circuito
 * @property int $estado_circuito
 */
class Circuito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'circuito';
    }
    //codigo que permite convertir minusculas o mayusculas o viceversa
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->nombre_circuito = strtoupper($this->nombre_circuito);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_circuito','estado_circuito'], 'required'],
            [['estado_circuito'], 'integer'],
            [['nombre_circuito'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_circuito' => 'Código',
            'nombre_circuito' => 'Nombre Circuito',
            'estado_circuito' => 'Activo',
        ];
    }
     public function getActivo()
    {
        if ($this->estado_circuito == 0){
            $estado = "SI";
        }else{
            $estado = "NO";
        }
        return $estado;
    }
}
