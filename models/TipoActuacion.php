<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_actuacion".
 *
 * @property int $id_tipo
 * @property string $anotacion
 *
 * @property Actuaciones[] $actuaciones
 */
class TipoActuacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_actuacion';
    }
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	$this->anotacion = strtoupper($this->anotacion);
       		
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['anotacion'], 'required'],
            [['anotacion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo' => 'Tipo',
            'anotacion' => 'Anotacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActuaciones()
    {
        return $this->hasMany(Actuaciones::className(), ['id_tipo' => 'id_tipo']);
    }
}
