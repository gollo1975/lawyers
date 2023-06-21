<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_compra_proceso".
 *
 * @property int $id_tipo_compra
 * @property string $descripcion
 * @property int $estado_tipo
 */
class TipoCompraProceso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_compra_proceso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'estado_tipo'], 'required'],
            [['estado_tipo'], 'integer'],
            [['descripcion'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_compra' => 'Id Tipo Compra',
            'descripcion' => 'Descripcion',
            'estado_tipo' => 'Estado Tipo',
        ];
    }
    
     public function getTipocompra()
    {
        return $this->hasMany(TipoCompraProceso::className(), ['id_tipo_compra' => 'id_tipo_compra']);
    }
}
