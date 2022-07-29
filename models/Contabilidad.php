<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cantabilidad".
 *
 * @property int $consecutivo
 * @property string $cuenta
 * @property string $comprobante
 * @property string $proceso
 * @property string $fecha
 * @property string $documento
 * @property string $documento_ref
 * @property resource $nit
 * @property string $detalle
 * @property int $tipo
 * @property double $valor
 * @property double $base
 * @property string $centro_costo
 * @property string $transporte
 * @property int $plazo
 */
class Contabilidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contabilidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['tipo', 'plazo'], 'integer'],
            [['valor', 'base'], 'number'],
            [['cuenta', 'documento', 'documento_ref', 'nit'], 'string', 'max' => 25],
            [['comprobante'], 'string', 'max' => 15],
            [['proceso', 'centro_costo'], 'string', 'max' => 50],
            [['detalle'], 'string', 'max' => 120],
            [['transporte'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'consecutivo' => 'Consecutivo',
            'cuenta' => 'Cuenta',
            'comprobante' => 'Comprobante',
            'proceso' => 'Proceso',
            'fecha' => 'Fecha',
            'documento' => 'Documento',
            'documento_ref' => 'Documento Ref',
            'nit' => 'Nit',
            'detalle' => 'Detalle',
            'tipo' => 'Tipo',
            'valor' => 'Valor',
            'base' => 'Base',
            'centro_costo' => 'Centro Costo',
            'transporte' => 'Transporte',
            'plazo' => 'Plazo',
        ];
    }
}
