<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notacreditodetalle".
 *
 * @property int $iddetallenota
 * @property string $fecha
 * @property int $idfactura
 * @property int $nrofactura
 * @property double $valor
 * @property string $usuariosistema
 * @property int $idnotacredito
 *
 * @property Facturaventa $factura
 * @property Notacredito $notacredito
 */
class Notacreditodetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notacreditodetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['idfactura', 'nrofactura', 'idnotacredito'], 'integer'],
            [['valor'], 'number'],
            [['idnotacredito'], 'required'],
            [['usuariosistema'], 'string', 'max' => 50],
            [['idfactura'], 'exist', 'skipOnError' => true, 'targetClass' => Facturaventa::className(), 'targetAttribute' => ['idfactura' => 'idfactura']],
            [['idnotacredito'], 'exist', 'skipOnError' => true, 'targetClass' => Notacredito::className(), 'targetAttribute' => ['idnotacredito' => 'idnotacredito']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddetallenota' => 'Iddetallenota',
            'fecha' => 'Fecha',
            'idfactura' => 'Idfactura',
            'nrofactura' => 'Nrofactura',
            'valor' => 'Valor',
            'usuariosistema' => 'Usuariosistema',
            'idnotacredito' => 'Idnotacredito',
        ];
    }

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
    public function getNotacredito()
    {
        return $this->hasOne(Notacredito::className(), ['idnotacredito' => 'idnotacredito']);
    }
}
