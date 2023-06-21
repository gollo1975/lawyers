<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_factura".
 *
 * @property int $tipo_factura
 * @property string $concepto
 * @property double $porcentaje_retencion
 * @property int $estado
 *
 * @property Facturaventa[] $facturaventas
 */
class TipoFactura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_factura';
    }
     public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	$this->concepto = strtoupper($this->concepto);
       		
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['concepto'], 'required'],
            [['porcentaje_retencion'], 'number'],
            [['estado'], 'integer'],
            [['concepto'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tipo_factura' => 'Id',
            'concepto' => 'Concepto',
            'porcentaje_retencion' => '% Retencion',
            'estado' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaventas()
    {
        return $this->hasMany(Facturaventa::className(), ['tipo_factura' => 'tipo_factura']);
    }
    public function getEstados()
    {
        if($this->estado == 1){
            $estado = "SI";
        }else{
            $estado = "NO";
        }
        return $estado;
    }
}
