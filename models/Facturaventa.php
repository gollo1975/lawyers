<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturaventa".
 *
 * @property int $idfactura
 * @property int $nrofactura
 * @property string $fechainicio
 * @property string $fechavcto
 * @property string $fechacreacion
 * @property string $formapago
 * @property int $plazopago
 * @property double $porcentajeiva
 * @property double $porcentajefuente
 * @property double $porcentajereteiva
 * @property double $subtotal
 * @property double $retencionfuente
 * @property double $impuestoiva
 * @property double $retencioniva
 * @property double $saldo
 * @property double $totalpagar
 * @property string $valorletras
 * @property int $idcliente
 * @property string $usuariosistema
 * @property int $idresolucion
 * @property int $estado estado 0 = abieto, estado 1 = abono, estado 2 = pagada, estado 3 = anulada,
 * @property int $autorizado
 * @property string $observacion
 * @property string $nrofacturaelectronica
 * @property int $tipo_factura
 *
 * @property Cliente $cliente
 * @property Resolucion $resolucion
 * @property TipoFactura $tipoFactura
 * @property Facturaventadetalle[] $facturaventadetalles
 * @property Notacreditodetalle[] $notacreditodetalles
 * @property Recibocajadetalle[] $recibocajadetalles
 * @property Stockdescargas[] $stockdescargas
 */
class Facturaventa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'facturaventa';
    }
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->observacion = strtoupper($this->observacion);
         $this->nrofacturaelectronica = strtoupper($this->nrofacturaelectronica);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nro_factura', 'plazopago', 'idcliente', 'idresolucion', 'estado', 'autorizado', 'tipo_factura','nro_demanda','aplica_iva'], 'integer'],
            [['fecha_inicio', 'idcliente','nro_demanda'], 'required'],
            [['fecha_inicio', 'fecha_vencimiento', 'fechacreacion'], 'safe'],
            [['porcentajeiva', 'porcentajefuente', 'porcentajereteiva', 'subtotal', 'retencionfuente', 'impuestoiva', 'retencioniva', 'saldo', 'totalpagar'], 'number'],
            [['valorletras', 'observacion'], 'string'],
            [['formapago', 'nrofacturaelectronica'], 'string', 'max' => 15],
            [['usuariosistema'], 'string', 'max' => 50],
            [['idcliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['idcliente' => 'idcliente']],
            [['idresolucion'], 'exist', 'skipOnError' => true, 'targetClass' => Resolucion::className(), 'targetAttribute' => ['idresolucion' => 'idresolucion']],
            [['tipo_factura'], 'exist', 'skipOnError' => true, 'targetClass' => TipoFactura::className(), 'targetAttribute' => ['tipo_factura' => 'tipo_factura']],
            [['nro_demanda'], 'exist', 'skipOnError' => true, 'targetClass' => Demandas::className(), 'targetAttribute' => ['nro_demanda' => 'nro_demanda']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idfactura' => 'Id:',
            'nro_factura' => 'No factura:',
            'fecha_inicio' => 'Fecha inicio:',
            'fecha_vencimiento' => 'Fecha vencimiento:',
            'fechacreacion' => 'Fecha creacion:',
            'formapago' => 'Forma pago:',
            'plazopago' => 'Plazo:',
            'porcentajeiva' => '% Iva:',
            'porcentajefuente' => '% Retención fuente',
            'porcentajereteiva' => '% Rete iva:',
            'subtotal' => 'Subtotal:',
            'retencionfuente' => 'Total retencion:',
            'impuestoiva' => 'Impuesto:',
            'retencioniva' => 'Retencion iva:',
            'saldo' => 'Saldo',
            'totalpagar' => 'Total factura:',
            'valorletras' => 'Valorletras',
            'idcliente' => 'Cliente:',
            'usuariosistema' => 'Usuario:',
            'idresolucion' => 'Rsolucion',
            'estado' => 'Estado',
            'autorizado' => 'Autorizado',
            'observacion' => 'Observacion',
            'nrofacturaelectronica' => 'Factura electronica:',
            'tipo_factura' => 'Tipo Factura',
            'nro_demanda' => 'No proceso:',
            'aplica_iva' => 'Aplica iva:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getOrden($provid)
    {

        $data= \app\models\Demandas::find()
            ->where(['idcliente'=>$provid])
            ->select(['nro_demanda as id'])->asArray()->all();

        return $data;
    }
    
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['idcliente' => 'idcliente']);
    }
    
    public function getDemanda()
    {
        return $this->hasOne(Demandas::className(), ['nro_demanda' => 'nro_demanda']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResolucion()
    {
        return $this->hasOne(Resolucion::className(), ['idresolucion' => 'idresolucion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoFactura()
    {
        return $this->hasOne(TipoFactura::className(), ['tipo_factura' => 'tipo_factura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaventadetalles()
    {
        return $this->hasMany(Facturaventadetalle::className(), ['idfactura' => 'idfactura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotacreditodetalles()
    {
        return $this->hasMany(Notacreditodetalle::className(), ['idfactura' => 'idfactura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibocajadetalles()
    {
        return $this->hasMany(Recibocajadetalle::className(), ['idfactura' => 'idfactura']);
    }

    public function getFormaPago(){
        if($this->formapago == 1){
            $formapago = 'CONTADO';
        }else{
            $formapago = 'CREDITO';
        }
        return $formapago;
    }
    public function getAutorizadoFactura(){
        if($this->autorizado == 1){
            $autorizadofactura = 'SI';
        }else{
            $autorizadofactura = 'NO';
        }
        return $autorizadofactura;
    }
    public function getestadoFactura(){
        if($this->estado == 0){
            $estadofactura = 'ACTIVA';
        }    
        if($this->estado == 1){
            $estadofactura = 'ABONO';
        }
        if($this->estado == 2){
            $estadofactura = 'CANCELADA';
        }
        if($this->estado == 3){
            $estadofactura = 'ANULADA';
        }
        return $estadofactura;
    }
}
