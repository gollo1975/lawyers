<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicio_prestado".
 *
 * @property int $id_servicio
 * @property int $nro_demanda
 * @property int $id_factura_venta_tipo
 * @property int $forma_pago
 * @property int $valor_pagar
 * @property string $fecha_registro
 * @property string $usuario
 * @property string $observacion
 *
 * @property Demandas $nroDemanda
 * @property Facturaventatipo $facturaVentaTipo
 */
class ServicioPrestado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicio_prestado';
    }
     public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->observacion = strtoupper($this->observacion); 
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nro_demanda', 'id_factura_venta_tipo', 'forma_pago', 'valor_pagar'], 'required'],
            [['nro_demanda', 'id_factura_venta_tipo', 'forma_pago', 'valor_pagar','saldo_servicio'], 'integer'],
            [['fecha_registro'], 'safe'],
            [['usuario'], 'string', 'max' => 20],
            [['observacion'], 'string', 'max' => 100],
            [['nro_demanda'], 'exist', 'skipOnError' => true, 'targetClass' => Demandas::className(), 'targetAttribute' => ['nro_demanda' => 'nro_demanda']],
            [['id_factura_venta_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Facturaventatipo::className(), 'targetAttribute' => ['id_factura_venta_tipo' => 'id_factura_venta_tipo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_servicio' => 'Id',
            'nro_demanda' => 'Nro proceso',
            'id_factura_venta_tipo' => 'Servicio:',
            'forma_pago' => 'Forma Pago:',
            'valor_pagar' => 'Valor Pagar:',
            'fecha_registro' => 'Fecha Registro:',
            'usuario' => 'Usuario:',
            'observacion' => 'Observacion:',
            'saldo_servicio' => 'Saldo:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNroDemanda()
    {
        return $this->hasOne(Demandas::className(), ['nro_demanda' => 'nro_demanda']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaVentaTipo()
    {
        return $this->hasOne(Facturaventatipo::className(), ['id_factura_venta_tipo' => 'id_factura_venta_tipo']);
    }
     public function getFormaPago(){
        if($this->forma_pago == 1){
            $formapago = 'CONTADO';
        }else{
            $formapago = 'CREDITO';
        }
        return $formapago;
    }
    
     public function getFacturaventadetalles()
    {
        return $this->hasMany(Facturaventadetalle::className(), ['id_factura_venta_tipo' => 'id_factura_venta_tipo']);
    }
}
