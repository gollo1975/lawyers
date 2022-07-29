<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturaventadetalle".
 *
 * @property int $id_detalle
 * @property int $idfactura
 * @property int $id_factura_venta_tipo
 * @property int $nro_demanda
 * @property int $cantidad
 * @property double $preciounitario
 * @property double $total
 *
 * @property Productodetalle $facturaVentaTipo
 * @property Facturaventa $factura
 * @property Facturaventatipo $facturaVentaTipo0
 * @property Demandas $nroDemanda
 */
class Facturaventadetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'facturaventadetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idfactura', 'id_factura_venta_tipo', 'cantidad', 'preciounitario', 'total'], 'required'],
            [['idfactura', 'id_factura_venta_tipo', 'nro_demanda', 'cantidad'], 'integer'],
            [['preciounitario', 'total'], 'number'],
            [['id_factura_venta_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Productodetalle::className(), 'targetAttribute' => ['id_factura_venta_tipo' => 'idproductodetalle']],
            [['idfactura'], 'exist', 'skipOnError' => true, 'targetClass' => Facturaventa::className(), 'targetAttribute' => ['idfactura' => 'idfactura']],
            [['id_factura_venta_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Facturaventatipo::className(), 'targetAttribute' => ['id_factura_venta_tipo' => 'id_factura_venta_tipo']],
            [['nro_demanda'], 'exist', 'skipOnError' => true, 'targetClass' => Demandas::className(), 'targetAttribute' => ['nro_demanda' => 'nro_demanda']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_detalle' => 'Id Detalle',
            'idfactura' => 'Idfactura',
            'id_factura_venta_tipo' => 'Id Factura Venta Tipo',
            'nro_demanda' => 'Nro Demanda',
            'cantidad' => 'Cantidad',
            'preciounitario' => 'Preciounitario',
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactura()
    {
        return $this->hasOne(Facturaventa::className(), ['idfactura' => 'idfactura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaVentaTipoS()
    {
        return $this->hasOne(Facturaventatipo::className(), ['id_factura_venta_tipo' => 'id_factura_venta_tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNroDemanda()
    {
        return $this->hasOne(Demandas::className(), ['nro_demanda' => 'nro_demanda']);
    }
}
