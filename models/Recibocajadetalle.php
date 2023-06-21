<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recibocajadetalle".
 *
 * @property int $iddetallerecibo
 * @property int $idfactura
 * @property double $vlrabono
 * @property double $vlrsaldo
 * @property double $retefuente
 * @property double $reteiva
 * @property double $reteica
 * @property int $idrecibo
 * @property string $observacion
 * @property string $nrofacturaelectronica
 *
 * @property Recibocaja $recibo
 * @property Facturaventa $factura
 */
class Recibocajadetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recibocajadetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idfactura', 'idrecibo',], 'required'],
            [['idfactura', 'idrecibo'], 'integer'],
            [['nrofacturaelectronica'], 'string'],
            [['vlrabono', 'vlrsaldo', 'retefuente', 'reteiva', 'reteica'], 'number'],
            [['observacion'], 'string'],
            [['idrecibo'], 'exist', 'skipOnError' => true, 'targetClass' => Recibocaja::className(), 'targetAttribute' => ['idrecibo' => 'idrecibo']],
            [['idfactura'], 'exist', 'skipOnError' => true, 'targetClass' => Facturaventa::className(), 'targetAttribute' => ['idfactura' => 'idfactura']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddetallerecibo' => 'Iddetallerecibo',
            'idfactura' => 'Idfactura',
            'vlrabono' => 'Vlrabono',
            'vlrsaldo' => 'Vlrsaldo',
            'retefuente' => 'Retefuente',
            'reteiva' => 'Reteiva',
            'reteica' => 'Reteica',
            'idrecibo' => 'Idrecibo',
            'nrofacturaelectronica' => 'Nro Factura Electrónica',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibo()
    {
        return $this->hasOne(Recibocaja::className(), ['idrecibo' => 'idrecibo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactura()
    {
        return $this->hasOne(Facturaventa::className(), ['idfactura' => 'idfactura']);
    }
}
