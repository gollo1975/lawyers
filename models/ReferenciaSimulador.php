<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "referencia_simulador".
 *
 * @property int $id_simulador
 * @property int $id_insumo
 * @property string $referencia
 * @property int $valor_costo
 * @property double $cantidad
 * @property int $total_linea
 * @property int $codigo
 * @property string $fecha_proceso
 * @property string $user_name
 *
 * @property Insumos $insumo
 * @property ReferenciaProducto $codigo0
 */
class ReferenciaSimulador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referencia_simulador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_insumo', 'valor_costo', 'total_linea', 'codigo'], 'integer'],
            [['cantidad'], 'required'],
            [['cantidad'], 'number'],
            [['fecha_proceso'], 'safe'],
            [['user_name'], 'string', 'max' => 15],
            [['id_insumo'], 'exist', 'skipOnError' => true, 'targetClass' => Insumos::className(), 'targetAttribute' => ['id_insumo' => 'id_insumo']],
            [['codigo'], 'exist', 'skipOnError' => true, 'targetClass' => ReferenciaProducto::className(), 'targetAttribute' => ['codigo' => 'codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_simulador' => 'Id Simulador',
            'id_insumo' => 'Id Insumo',
            'valor_costo' => 'Valor Costo',
            'cantidad' => 'Cantidad',
            'total_linea' => 'Total Linea',
            'codigo' => 'Codigo',
            'fecha_proceso' => 'Fecha Proceso',
            'user_name' => 'User Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsumo()
    {
        return $this->hasOne(Insumos::className(), ['id_insumo' => 'id_insumo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigo0()
    {
        return $this->hasOne(ReferenciaProducto::className(), ['codigo' => 'codigo']);
    }
}
