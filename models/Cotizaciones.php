<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cotizaciones".
 *
 * @property int $id_cotizacion
 * @property int $id_cliente
 * @property int $numero_cotizacion
 * @property string $fecha_cotizacion
 * @property string $fecha_entrega
 * @property string $fecha_registro
 * @property int $total_prendas
 * @property int $subtotal
 * @property int $impuesto
 * @property int $total_cotizacion
 * @property int $autorizado
 * @property int $proceso_cerrado
 * @property string $user_name
 * @property string $observacion
 *
 * @property CotizacionDetalle[] $cotizacionDetalles
 * @property Cliente $cliente
 */
class Cotizaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cotizaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cliente', 'fecha_entrega', 'observacion'], 'required'],
            [['id_cliente', 'numero_cotizacion', 'total_prendas', 'subtotal', 'impuesto', 'total_cotizacion', 'autorizado', 'proceso_cerrado'], 'integer'],
            [['fecha_cotizacion', 'fecha_entrega', 'fecha_registro'], 'safe'],
            [['user_name'], 'string', 'max' => 15],
            [['observacion'], 'string', 'max' => 100],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['id_cliente' => 'idcliente']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cotizacion' => 'Id:',
            'id_cliente' => 'Cliente:',
            'numero_cotizacion' => 'Numero cotizacion:',
            'fecha_cotizacion' => 'Fecha cotizacion:',
            'fecha_entrega' => 'Fecha entrega:',
            'fecha_registro' => 'Fecha registro:',
            'total_prendas' => 'Total prendas:',
            'subtotal' => 'Subtotal:',
            'impuesto' => 'Impuesto:',
            'total_cotizacion' => 'Total cotizacion:',
            'autorizado' => 'Autorizado:',
            'proceso_cerrado' => 'Proceso cerrado:',
            'user_name' => 'User Name',
            'observacion' => 'Observacion:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionDetalles()
    {
        return $this->hasMany(CotizacionDetalle::className(), ['id_cotizacion' => 'id_cotizacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['idcliente' => 'id_cliente']);
    }
    
    public function getAutorizado() {
        if($this->autorizado == 0){
            $autorizado = 'NO';
        }else{
            $autorizado = 'SI';            
        }
        return $autorizado;
    }
    
    public function getProcesoCerrado() {
        if($this->proceso_cerrado == 0){
            $procesocerrado = 'NO';
        }else{
            $procesocerrado = 'SI';            
        }
        return $procesocerrado;
    }
}