<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comprobante_egreso_detalle".
 *
 * @property int $id_comprobante_egreso_detalle
 * @property int $id_compra
 * @property int $id_comprobante_egreso
 * @property double $vlr_abono
 * @property double $vlr_saldo
 * @property double $retefuente
 * @property double $reteiva
 * @property double $reteica
 * @property double $iva
 * @property double $base_aiu
 * @property string $observacion
 *
 * @property Compra $compra
 * @property ComprobanteEgreso $comprobanteEgreso
 */
class ComprobanteEgresoDetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comprobante_egreso_detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_compra', 'id_comprobante_egreso'], 'integer'],
            [['id_comprobante_egreso'], 'required'],
            [['vlr_abono', 'vlr_saldo', 'retefuente', 'reteiva', 'reteica', 'iva', 'base_aiu'], 'number'],
            [['observacion'], 'string'],
            [['id_compra'], 'exist', 'skipOnError' => true, 'targetClass' => Compra::className(), 'targetAttribute' => ['id_compra' => 'id_compra']],
            [['id_comprobante_egreso'], 'exist', 'skipOnError' => true, 'targetClass' => ComprobanteEgreso::className(), 'targetAttribute' => ['id_comprobante_egreso' => 'id_comprobante_egreso']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_comprobante_egreso_detalle' => 'Id Comprobante Egreso Detalle',
            'id_compra' => 'Id Compra',
            'id_comprobante_egreso' => 'Id Comprobante Egreso',
            'vlr_abono' => 'Vlr Abono',
            'vlr_saldo' => 'Vlr Saldo',
            'retefuente' => 'Retefuente',
            'reteiva' => 'Reteiva',
            'reteica' => 'Reteica',
            'iva' => 'Iva',
            'base_aiu' => 'Base Aiu',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompra()
    {
        return $this->hasOne(Compra::className(), ['id_compra' => 'id_compra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprobanteEgreso()
    {
        return $this->hasOne(ComprobanteEgreso::className(), ['id_comprobante_egreso' => 'id_comprobante_egreso']);
    }
}
