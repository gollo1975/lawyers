<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "conceptonotacuenta".
 *
 * @property int $idconceptonotacuenta
 * @property int $cuenta
 * @property int $tipocuenta
 * @property int $idconceptonota
 * @property int $base
 * @property int $subtotal
 * @property int $iva
 * @property int $rete_fuente
 * @property int $rete_iva
 * @property int $total
 * @property int $base_rete_fuente
 * @property double $porcentaje_base
 *
 * @property Conceptonota $conceptonota
 */
class Conceptonotacuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conceptonotacuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuenta', 'tipocuenta'], 'required'],
            [['cuenta', 'tipocuenta', 'idconceptonota', 'base', 'subtotal', 'iva', 'rete_fuente', 'rete_iva', 'total', 'base_rete_fuente'], 'integer'],
            [['porcentaje_base'], 'number'],
            [['idconceptonota'], 'exist', 'skipOnError' => true, 'targetClass' => Conceptonota::className(), 'targetAttribute' => ['idconceptonota' => 'idconceptonota']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idconceptonotacuenta' => 'Idconceptonotacuenta',
            'cuenta' => 'Cuenta',
            'tipocuenta' => 'Tipocuenta',
            'idconceptonota' => 'Idconceptonota',
            'base' => 'Base',
            'subtotal' => 'Subtotal',
            'iva' => 'Iva',
            'rete_fuente' => 'Rete Fuente',
            'rete_iva' => 'Rete Iva',
            'total' => 'Total',
            'base_rete_fuente' => 'Base Rete Fuente',
            'porcentaje_base' => '% Base',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConceptonota()
    {
        return $this->hasOne(Conceptonota::className(), ['idconceptonota' => 'idconceptonota']);
    }
}
