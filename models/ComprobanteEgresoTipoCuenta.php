<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comprobante_egreso_tipo_cuenta".
 *
 * @property int $id_comprobante_egreso_tipo_cuenta
 * @property int $cuenta
 * @property int $tipocuenta
 * @property int $base
 * @property int $id_comprobante_egreso_tipo
 * @property int $subtotal
 * @property int $iva
 * @property int $rete_fuente
 * @property int $rete_iva
 * @property int $total
 * @property int $base_rete_fuente
 * @property double $porcentaje_base
 *
 * @property ComprobanteEgresoTipo $comprobanteEgresoTipo
 */
class ComprobanteEgresoTipoCuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comprobante_egreso_tipo_cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuenta', 'tipocuenta'], 'required'],
            [['cuenta', 'tipocuenta', 'id_compra_concepto', 'base', 'subtotal', 'iva', 'rete_fuente', 'rete_iva', 'total', 'base_rete_fuente','id_comprobante_egreso_tipo'], 'integer'],
            [['porcentaje_base'], 'number'],
            [['id_comprobante_egreso_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => ComprobanteEgresoTipo::className(), 'targetAttribute' => ['id_comprobante_egreso_tipo' => 'id_comprobante_egreso_tipo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_comprobante_egreso_tipo_cuenta' => 'Id Comprobante Egreso Tipo Cuenta',
            'cuenta' => 'Cuenta',
            'tipocuenta' => 'Tipocuenta',            
            'id_comprobante_egreso_tipo' => 'Id Comprobante Egreso Tipo',
            'base' => 'Base',
            'subtotal' => 'Subtotal',
            'iva' => 'Iva',
            'rete_fuente' => 'Rete Fuente',
            'rete_iva' => 'Rete Iva',
            'total' => 'Total',
            'base_rete_fuente' => 'Base Rete Fuente',
            'porcentaje_base' => 'porcentaje_base',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprobanteEgresoTipo()
    {
        return $this->hasOne(ComprobanteEgresoTipo::className(), ['id_comprobante_egreso_tipo' => 'id_comprobante_egreso_tipo']);
    }
}
