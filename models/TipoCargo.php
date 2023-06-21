<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_cargo".
 *
 * @property int $id_tipo_cargo
 * @property string $tipo
 *
 * @property CostoLaboralDetalle[] $costoLaboralDetalles
 */
class TipoCargo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_cargo';
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->tipo = strtoupper($this->tipo);        
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo'], 'required', 'message' => 'Campo requerido'],
            [['tipo'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_cargo' => 'Id Tipo',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCostoLaboralDetalles()
    {
        return $this->hasMany(CostoLaboralDetalle::className(), ['id_tipo_cargo' => 'id_tipo_cargo']);
    }
}
