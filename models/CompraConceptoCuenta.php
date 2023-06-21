<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra_concepto_cuenta".
 *
 * @property int $id_compra_concepto_cuenta
 * @property int $cuenta
 * @property int $tipocuenta
 * @property int $id_compra_concepto
 * @property int $base
 * @property int $subtotal
 * @property int $iva
 * @property int $rete_fuente
 * @property int $rete_iva
 * @property int $total
 * @property int $base_rete_fuente
 * @property double $porcentaje_base
 *
 * @property CompraConcepto $compraConcepto
 */
class CompraConceptoCuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compra_concepto_cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuenta', 'tipocuenta', 'id_compra_concepto'], 'required'],
            [['cuenta', 'tipocuenta', 'id_compra_concepto', 'base', 'subtotal', 'iva', 'rete_fuente', 'rete_iva', 'total', 'base_rete_fuente'], 'integer'],
            [['porcentaje_base'], 'number'],
            [['id_compra_concepto'], 'exist', 'skipOnError' => true, 'targetClass' => CompraConcepto::className(), 'targetAttribute' => ['id_compra_concepto' => 'id_compra_concepto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_compra_concepto_cuenta' => 'Id Compra Concepto Cuenta',
            'cuenta' => 'Cuenta',
            'tipocuenta' => 'Tipocuenta',
            'id_compra_concepto' => 'Id Compra Concepto',
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
    public function getCompraConcepto()
    {
        return $this->hasOne(CompraConcepto::className(), ['id_compra_concepto' => 'id_compra_concepto']);
    }
}
