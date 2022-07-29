<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distrito".
 *
 * @property int $id_distrito
 * @property string $nombre_distrito
 * @property int $estado
 */
class Distrito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'distrito';
    }
     public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->nombre_distrito = strtoupper($this->nombre_distrito);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_distrito','estado'], 'required'],
            [['estado'], 'integer'],
            [['nombre_distrito'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_distrito' => 'Código',
            'nombre_distrito' => 'Nombre Distrito',
            'estado' => 'Activo',
        ];
    }
     public function getActivo()
    {
        if ($this->estado == 0){
            $estado = "SI";
        }else{
            $estado = "NO";
        }
        return $estado;
    }
}
