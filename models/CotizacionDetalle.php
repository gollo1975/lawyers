<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cotizacion_detalle".
 *
 * @property int $id
 * @property int $id_cotizacion
 * @property int $codigo
 * @property string $referencia
 * @property int $id_detalle
 * @property int $cantidad_referencia
 * @property int $valor_unidad
 * @property int $impuesto
 * @property int $total_linea
 * @property string $user_name
 *
 * @property Cotizaciones $cotizacion
 * @property ReferenciaProducto $codigo0
 * @property ReferenciaListaPrecio $detalle
 */
class CotizacionDetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cotizacion_detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cotizacion', 'codigo', 'id_detalle', 'cantidad_referencia', 'valor_unidad','subtotal','impuesto', 'total_linea'], 'integer'],
            [['referencia'], 'string', 'max' => 40],
            [['user_name'], 'string', 'max' => 15],
            [['nota'], 'string', 'max' => 150],
            [['id_cotizacion'], 'exist', 'skipOnError' => true, 'targetClass' => Cotizaciones::className(), 'targetAttribute' => ['id_cotizacion' => 'id_cotizacion']],
            [['codigo'], 'exist', 'skipOnError' => true, 'targetClass' => ReferenciaProducto::className(), 'targetAttribute' => ['codigo' => 'codigo']],
            [['id_detalle'], 'exist', 'skipOnError' => true, 'targetClass' => ReferenciaListaPrecio::className(), 'targetAttribute' => ['id_detalle' => 'id_detalle']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cotizacion' => 'Id Cotizacion',
            'codigo' => 'Codigo',
            'referencia' => 'Referencia',
            'id_detalle' => 'Id Detalle',
            'cantidad_referencia' => 'Cantidad Referencia',
            'valor_unidad' => 'Valor Unidad',
            'impuesto' => 'Impuesto',
            'total_linea' => 'Total Linea',
            'user_name' => 'User Name',
            'subtotal' => 'subtotal',
            'nota' => 'nota(150)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacion()
    {
        return $this->hasOne(Cotizaciones::className(), ['id_cotizacion' => 'id_cotizacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoReferencia()
    {
        return $this->hasOne(ReferenciaProducto::className(), ['codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalle()
    {
        return $this->hasOne(ReferenciaListaPrecio::className(), ['id_detalle' => 'id_detalle']);
    }
}
