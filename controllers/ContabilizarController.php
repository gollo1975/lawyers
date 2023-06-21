<?php

namespace app\controllers;

use Codeception\Lib\HelperModule;
use yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\FormFiltroContabilizar;
use yii\web\UploadedFile;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\UsuarioDetalle;
use app\models\Contabilidad;
use app\models\Recibocaja;
use app\models\Recibocajadetalle;
use app\models\Compra;
use app\models\Notacredito;
use app\models\Notacreditodetalle;
use app\models\ComprobanteEgreso;
use app\models\ComprobanteEgresoDetalle;
use app\models\Facturaventa;
use app\models\Facturaventadetalle;
use app\models\Tiporecibocuenta;
use app\models\CuentaPub;
use app\models\Facturaventatipocuenta;
use app\models\CompraConceptoCuenta;
use app\models\ComprobanteEgresoTipoCuenta;
use app\models\Conceptonotacuenta;

class ContabilizarController extends Controller {        
    
    public function actionContabilizar() {
        if (Yii::$app->user->identity){
        if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',33])->all()){
            $form = new FormFiltroContabilizar;
            $proceso = null;
            $fechadesde = null;
            $fechahasta = null;
            if ($form->load(Yii::$app->request->get())) {
                if ($form->validate()) {                    
                    $proceso = Html::encode($form->proceso);
                    $fechadesde = Html::encode($form->desde);
                    $fechahasta = Html::encode($form->hasta);
                    //se realiza la inserción de los registros en la tabla contabilidad
                    if ($proceso){
                        $this->Generar($proceso,$fechadesde,$fechahasta);
                    }
                    //fin proceso
                    $table = Contabilidad::find()
                            ->andFilterWhere(['=', 'comprobante', $proceso])
                            ->andFilterWhere(['>=', 'fecha', $fechadesde])
                            ->andFilterWhere(['<=', 'fecha', $fechahasta])
                            ->orderBy('fecha asc');
                    $exportar = $table->all();
                    $count = clone $table;
                    $to = $count->count();
                    $pages = new Pagination([
                        'pageSize' => 22,
                        'totalCount' => $count->count()
                    ]);
                    $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                    if(isset($_POST['excel'])){
                        //$table = $table->all();
                        $this->actionExcel($exportar);
                    }
                    if(isset($_POST['contai'])){
                        //$table = $table->all();
                        $this->actionContai($exportar);
                    }
                } else {
                    $form->getErrors();
                }
            } else {
                $table = Contabilidad::find()->where(['=','consecutivo', 0])
                        ->orderBy('fecha asc');
                $exportar = $table->all();
                $count = clone $table;
                $pages = new Pagination([
                    'pageSize' => 22,
                    'totalCount' => $count->count(),
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                if(isset($_POST['excel'])){
                    //$table = $table->all();
                    $this->actionExcel($exportar);
                }
                if(isset($_POST['contai'])){
                    //$table = $table->all();
                    $this->actionContai($exportar);
                }
            }
            $to = $count->count();
            return $this->render('contabilizar', [
                        'model' => $model,
                        'form' => $form,
                        'pagination' => $pages,
            ]);
        }else{
            return $this->redirect(['site/sinpermiso']);
        }
        }else{
            return $this->redirect(['site/login']);
        }
    }
    
    protected function Generar($proceso,$fechadesde,$fechahasta) {        
        //inicio borrar registros
        Contabilidad::deleteAll('consecutivo <> 0');
        //fin borrar registros        
        if ($proceso == 1){  //recibo de caja
            $reciboscaja = Recibocaja::find()->where(['>=','fechapago',$fechadesde])->andWhere(['<=','fechapago',$fechahasta])->all();
            foreach ($reciboscaja as $recibo) {
                $recibosdetalles = Recibocajadetalle::find()->where(['=','idrecibo',$recibo->idrecibo])->all();
                foreach ($recibosdetalles as $detalle){
                    $tipos = Tiporecibocuenta::find()->where(['=','idtiporecibo',$recibo->idtiporecibo])->all();
                    foreach ($tipos as $tipo){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $tipo->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'recibo de caja';
                        $contabilidad->fecha = $recibo->fechapago;
                        if($detalle->idfactura == ''){
                           $contabilidad->documento = 0;
                        }else{
                            $contabilidad->documento = $detalle->factura->nrofactura;
                        }
                        $contabilidad->documento_ref = $recibo->numero;
                        $empresa = CuentaPub::find()->where(['=','codigo_cuenta',$tipo->cuenta])->one();
                        if ($empresa){
                            if ($empresa->exige_nit == 1){
                                $nit = $recibo->cliente->cedulanit;
                            }else{
                                $nit = "";
                            }                                                         
                        }else {
                            $nit = "";
                        }
                        $contabilidad->nit = $nit;
                        $contabilidad->detalle = $recibo->tiporecibo->concepto;
                        $contabilidad->tipo = $tipo->tipocuenta;
                        $contabilidad->valor = $detalle->vlrabono;
                        $contabilidad->base = 0;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        $contabilidad->save(false);                        
                    }                    
                }    
            }
        }
        if ($proceso == 2){  //Comprobantes de Egresos
            $comprobantesegreso = ComprobanteEgreso::find()->where(['>=','fecha_comprobante',$fechadesde])->andWhere(['<=','fecha_comprobante',$fechahasta])->andWhere(['>','numero',0])->all();
            foreach ($comprobantesegreso as $comprobante) {                
                $tipos = ComprobanteEgresoTipoCuenta::find()->where(['=','id_comprobante_egreso_tipo',$comprobante->id_comprobante_egreso_tipo])->all();
                foreach ($tipos as $tipo){
                    if ($tipo->subtotal == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $tipo->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Egresos';
                        $contabilidad->fecha = $comprobante->fecha_comprobante;
                        $contabilidad->documento = $comprobante->numero;
                        $detalle = ComprobanteEgresoDetalle::find()->where(['=','id_comprobante_egreso',$comprobante->id_comprobante_egreso])->one();
                        if (isset($detalle->compra->factura) <> ""){                            
                            $nfactura = $detalle->compra->factura;
                        }else{
                            $nfactura = "";
                        }
                        $contabilidad->documento_ref = $nfactura;
                        $empresa = CuentaPub::find()->where(['=','codigo_cuenta',$tipo->cuenta])->one();
                        if ($empresa){
                            if ($empresa->exige_nit == 1){
                                $nit = $comprobante->proveedor->cedulanit;
                            }else{
                                $nit = "";
                            }                                                         
                        }else {
                            $nit = "";
                        }
                        $contabilidad->nit = $nit;                            
                        $contabilidad->detalle = substr($comprobante->comprobanteEgresoTipo->concepto, 0, 27);
                        $contabilidad->tipo = $tipo->tipocuenta;
                        $contabilidad->valor = $comprobante->subtotal;
                        if ($tipo->base == 1){
                            $base = $comprobante->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        $contabilidad->save(false);
                    }
                    if ($tipo->iva == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $tipo->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Egresos';
                        $contabilidad->fecha = $comprobante->fecha_comprobante;
                        $contabilidad->documento = $comprobante->numero;
                        $detalle = ComprobanteEgresoDetalle::find()->where(['=','id_comprobante_egreso',$comprobante->id_comprobante_egreso])->one();
                        if (isset($detalle->compra->factura) <> ""){                            
                            $nfactura = $detalle->compra->factura;
                        }else{
                            $nfactura = "";
                        }
                        $contabilidad->documento_ref = $nfactura;
                        $empresa = CuentaPub::find()->where(['=','codigo_cuenta',$tipo->cuenta])->one();
                        if ($empresa){
                            if ($empresa->exige_nit == 1){
                                $nit = $comprobante->proveedor->cedulanit;
                            }else{
                                $nit = "";
                            }                                                         
                        }else {
                            $nit = "";
                        }
                        $contabilidad->nit = $nit;                            
                        $contabilidad->detalle = substr($comprobante->comprobanteEgresoTipo->concepto, 0, 27);
                        $contabilidad->tipo = $tipo->tipocuenta;
                        $contabilidad->valor = $comprobante->iva;
                        if ($tipo->base == 1){
                            $base = $comprobante->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                        
                    }
                    if ($tipo->rete_fuente == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $tipo->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Egresos';
                        $contabilidad->fecha = $comprobante->fecha_comprobante;
                        $contabilidad->documento = $comprobante->numero;
                        $detalle = ComprobanteEgresoDetalle::find()->where(['=','id_comprobante_egreso',$comprobante->id_comprobante_egreso])->one();
                        if (isset($detalle->compra->factura) <> ""){                            
                            $nfactura = $detalle->compra->factura;
                        }else{
                            $nfactura = "";
                        }
                        $contabilidad->documento_ref = $nfactura;
                        $empresa = CuentaPub::find()->where(['=','codigo_cuenta',$tipo->cuenta])->one();
                        if ($empresa){
                            if ($empresa->exige_nit == 1){
                                $nit = $comprobante->proveedor->cedulanit;
                            }else{
                                $nit = "";
                            }                                                         
                        }else {
                            $nit = "";
                        }
                        $contabilidad->nit = $nit;                            
                        $contabilidad->detalle = $comprobante->comprobanteEgresoTipo->concepto;
                        $contabilidad->tipo = $tipo->tipocuenta;
                        $contabilidad->valor = $comprobante->retefuente;
                        if ($tipo->base == 1){
                            $base = $comprobante->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }
                    }
                    if ($tipo->rete_iva == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $tipo->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Egresos';
                        $contabilidad->fecha = $comprobante->fecha_comprobante;
                        $contabilidad->documento = $comprobante->numero;
                        $detalle = ComprobanteEgresoDetalle::find()->where(['=','id_comprobante_egreso',$comprobante->id_comprobante_egreso])->one();
                        if (isset($detalle->compra->factura) <> ""){                            
                            $nfactura = $detalle->compra->factura;
                        }else{
                            $nfactura = "";
                        }
                        $contabilidad->documento_ref = $nfactura;
                        $empresa = CuentaPub::find()->where(['=','codigo_cuenta',$tipo->cuenta])->one();
                        if ($empresa){
                            if ($empresa->exige_nit == 1){
                                $nit = $comprobante->proveedor->cedulanit;
                            }else{
                                $nit = "";
                            }                                                         
                        }else {
                            $nit = "";
                        }
                        $contabilidad->nit = $nit;                            
                        $contabilidad->detalle = substr($comprobante->comprobanteEgresoTipo->concepto, 0, 27);
                        $contabilidad->tipo = $tipo->tipocuenta;
                        $contabilidad->valor = $comprobante->reteiva;
                        if ($tipo->base == 1){
                            $base = $comprobante->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }
                    }
                    if ($tipo->total == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $tipo->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Egresos';
                        $contabilidad->fecha = $comprobante->fecha_comprobante;
                        $contabilidad->documento = $comprobante->numero;
                        $detalle = ComprobanteEgresoDetalle::find()->where(['=','id_comprobante_egreso',$comprobante->id_comprobante_egreso])->one();
                        if (isset($detalle->compra->factura) <> ""){                            
                            $nfactura = $detalle->compra->factura;
                        }else{
                            $nfactura = "";
                        }
                        $contabilidad->documento_ref = $nfactura;
                        $empresa = CuentaPub::find()->where(['=','codigo_cuenta',$tipo->cuenta])->one();
                        if ($empresa){
                            if ($empresa->exige_nit == 1){
                                $nit = $comprobante->proveedor->cedulanit;
                            }else{
                                $nit = "";
                            }                                                         
                        }else {
                            $nit = "";
                        }
                        $contabilidad->nit = $nit;                            
                        $contabilidad->detalle = substr($comprobante->comprobanteEgresoTipo->concepto, 0, 27);
                        $contabilidad->tipo = $tipo->tipocuenta;
                        $contabilidad->valor = $comprobante->valor;
                        if ($tipo->base == 1){
                            $base = $comprobante->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }
                    }
                    if ($tipo->base_rete_fuente == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $tipo->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Egresos';
                        $contabilidad->fecha = $comprobante->fecha_comprobante;
                        $contabilidad->documento = $comprobante->numero;
                        $detalle = ComprobanteEgresoDetalle::find()->where(['=','id_comprobante_egreso',$comprobante->id_comprobante_egreso])->one();
                        if (isset($detalle->compra->factura) <> ""){                            
                            $nfactura = $detalle->compra->factura;
                        }else{
                            $nfactura = "";
                        }
                        $contabilidad->documento_ref = $nfactura;
                        $empresa = CuentaPub::find()->where(['=','codigo_cuenta',$tipo->cuenta])->one();
                        if ($empresa){
                            if ($empresa->exige_nit == 1){
                                $nit = $comprobante->proveedor->cedulanit;
                            }else{
                                $nit = "";
                            }                                                         
                        }else {
                            $nit = "";
                        }
                        $contabilidad->nit = $nit;                            
                        $contabilidad->detalle = substr($comprobante->comprobanteEgresoTipo->concepto, 0, 27);
                        $contabilidad->tipo = $tipo->tipocuenta;
                        $contabilidad->valor = $comprobante->subtotal * $tipo->porcentaje_base / 100;
                        if ($tipo->base == 1){
                            $base = $comprobante->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }
                    }
                }                  
            }
        }
        if ($proceso == 4){  //Compras
            $compras = Compra::find()->where(['>=','fechainicio',$fechadesde])->andWhere(['<=','fechainicio',$fechahasta])->andWhere(['>','numero',0])->all();
            foreach ($compras as $compra) {
                $compraconceptocuentas = CompraConceptoCuenta::find()->where(['=','id_compra_concepto',$compra->id_compra_concepto])->all();
                foreach ($compraconceptocuentas as $detalle){
                    if ($detalle->subtotal == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Compras';
                        $contabilidad->fecha = $compra->fechainicio;
                        $contabilidad->documento = $compra->numero;
                        $contabilidad->documento_ref = $compra->factura;
                        $contabilidad->nit = $compra->proveedor->cedulanit;
                        $contabilidad->detalle = $compra->compraConcepto->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $compra->subtotal;
                        if ($detalle->base == 1){
                            $base = $compra->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                    
                    }
                    if ($detalle->iva == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Compras';
                        $contabilidad->fecha = $compra->fechainicio;
                        $contabilidad->documento = $compra->numero;
                        $contabilidad->documento_ref = $compra->factura;
                        $contabilidad->nit = $compra->proveedor->cedulanit;
                        $contabilidad->detalle = $compra->compraConcepto->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $compra->impuestoiva;
                        if ($detalle->base == 1){
                            $base = $compra->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        $contabilidad->save(false);
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }
                    }
                    if ($detalle->rete_fuente == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Compras';
                        $contabilidad->fecha = $compra->fechainicio;
                        $contabilidad->documento = $compra->numero;
                        $contabilidad->documento_ref = $compra->factura;
                        $contabilidad->nit = $compra->proveedor->cedulanit;
                        $contabilidad->detalle = $compra->compraConcepto->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $compra->retencionfuente;
                        if ($detalle->base == 1){
                            $base = $compra->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                    
                    }
                    if ($detalle->rete_iva == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Compras';
                        $contabilidad->fecha = $compra->fechainicio;
                        $contabilidad->documento = $compra->numero;
                        $contabilidad->documento_ref = $compra->factura;
                        $contabilidad->nit = $compra->proveedor->cedulanit;
                        $contabilidad->detalle = $compra->compraConcepto->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $compra->retencioniva;
                        if ($detalle->base == 1){
                            $base = $compra->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                    
                    }
                    if ($detalle->total == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Compras';
                        $contabilidad->fecha = $compra->fechainicio;
                        $contabilidad->documento = $compra->numero;
                        $contabilidad->documento_ref = $compra->factura;
                        $contabilidad->nit = $compra->proveedor->cedulanit;
                        $contabilidad->detalle = $compra->compraConcepto->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $compra->total;
                        if ($detalle->base == 1){
                            $base = $compra->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                    
                    }
                    if ($detalle->base_rete_fuente == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Compras';
                        $contabilidad->fecha = $compra->fechainicio;
                        $contabilidad->documento = $compra->numero;
                        $contabilidad->documento_ref = $compra->factura;
                        $contabilidad->nit = $compra->proveedor->cedulanit;
                        $contabilidad->detalle = $compra->compraConcepto->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $compra->subtotal * $detalle->porcentaje_base / 100;
                        if ($detalle->base == 1){
                            $base = $compra->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                   
                    }
                }    
            }
        }
        if ($proceso == 7){  //Facturacion            
            $facturas = Facturaventa::find()->where(['>=','fechainicio',$fechadesde])->andWhere(['<=','fechainicio',$fechahasta])->andWhere(['>','nrofactura',0])->all();
            foreach ($facturas as $factura) {
                $facturastiposcuentas = Facturaventatipocuenta::find()->where(['=','id_factura_venta_tipo',$factura->id_factura_venta_tipo])->all();
                foreach ($facturastiposcuentas as $detalle){
                    if ($detalle->subtotal == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Facturacion';
                        $contabilidad->fecha = $factura->fechainicio;
                        $contabilidad->documento = $factura->nrofactura;
                        $contabilidad->documento_ref = $factura->nrofactura;
                        $contabilidad->nit = $factura->cliente->cedulanit;
                        $contabilidad->detalle = $factura->facturaventatipo->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $factura->subtotal;
                        if ($detalle->base == 1){
                            $base = $factura->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }
                    }    
                    if ($detalle->iva == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Facturacion';
                        $contabilidad->fecha = $factura->fechainicio;
                        $contabilidad->documento = $factura->nrofactura;
                        $contabilidad->documento_ref = $factura->nrofactura;
                        $contabilidad->nit = $factura->cliente->cedulanit;
                        $contabilidad->detalle = $factura->facturaventatipo->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $factura->impuestoiva;
                        if ($detalle->base == 1){
                            $base = $factura->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                        
                    }
                    if ($detalle->rete_fuente == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Facturacion';
                        $contabilidad->fecha = $factura->fechainicio;
                        $contabilidad->documento = $factura->nrofactura;
                        $contabilidad->documento_ref = $factura->nrofactura;
                        $contabilidad->nit = $factura->cliente->cedulanit;
                        $contabilidad->detalle = $factura->facturaventatipo->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $factura->retencionfuente;
                        if ($detalle->base == 1){
                            $base = $factura->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                       
                    }
                    if ($detalle->rete_iva == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Facturacion';
                        $contabilidad->fecha = $factura->fechainicio;
                        $contabilidad->documento = $factura->nrofactura;
                        $contabilidad->documento_ref = $factura->nrofactura;
                        $contabilidad->nit = $factura->cliente->cedulanit;
                        $contabilidad->detalle = $factura->facturaventatipo->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $factura->retencioniva;
                        if ($detalle->base == 1){
                            $base = $factura->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                      
                    }
                    if ($detalle->total == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Facturacion';
                        $contabilidad->fecha = $factura->fechainicio;
                        $contabilidad->documento = $factura->nrofactura;
                        $contabilidad->documento_ref = $factura->nrofactura;
                        $contabilidad->nit = $factura->cliente->cedulanit;
                        $contabilidad->detalle = $factura->facturaventatipo->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $factura->totalpagar;
                        if ($detalle->base == 1){
                            $base = $factura->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                        
                    }
                    if ($detalle->base_rete_fuente == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Facturacion';
                        $contabilidad->fecha = $factura->fechainicio;
                        $contabilidad->documento = $factura->nrofactura;
                        $contabilidad->documento_ref = $factura->nrofactura;
                        $contabilidad->nit = $factura->cliente->cedulanit;
                        $contabilidad->detalle = $factura->facturaventatipo->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $factura->subtotal * $detalle->porcentaje_base / 100;
                        if ($detalle->base == 1){
                            $base = $factura->subtotal;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                       
                    }
                }    
            }
        }
        if ($proceso == 9){  //Notas Credito
            $notascreditos = Notacredito::find()->where(['>=','fecha',$fechadesde])->andWhere(['<=','fecha',$fechahasta])->andWhere(['>','numero',0])->all();
            foreach ($notascreditos as $notacredito) {
                $conceptonotacuentas = Conceptonotacuenta::find()->where(['=','idconceptonota',$notacredito->idconceptonota])->all();
                foreach ($compraconceptocuentas as $detalle){
                    if ($detalle->subtotal == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Notas Credito';
                        $contabilidad->fecha = $notacredito->fecha;
                        $contabilidad->documento = $notacredito->numero;
                        $contabilidad->documento_ref = $notacredito->factura;
                        $contabilidad->nit = $notacredito->cliente->cedulanit;
                        $contabilidad->detalle = $notacredito->conceptonota->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $notacredito->valor;
                        if ($detalle->base == 1){
                            $base = $notacredito->valor;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                   
                    }
                    if ($detalle->iva == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Notas Credito';
                        $contabilidad->fecha = $notacredito->fecha;
                        $contabilidad->documento = $notacredito->numero;
                        $contabilidad->documento_ref = $notacredito->factura;
                        $contabilidad->nit = $notacredito->cliente->cedulanit;
                        $contabilidad->detalle = $notacredito->conceptonota->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $notacredito->iva;
                        if ($detalle->base == 1){
                            $base = $notacredito->valor;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                    
                    }
                    if ($detalle->rete_fuente == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Notas Credito';
                        $contabilidad->fecha = $notacredito->fecha;
                        $contabilidad->documento = $notacredito->numero;
                        $contabilidad->documento_ref = $notacredito->factura;
                        $contabilidad->nit = $notacredito->cliente->cedulanit;
                        $contabilidad->detalle = $notacredito->conceptonota->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $notacredito->retefuente;
                        if ($detalle->base == 1){
                            $base = $notacredito->valor;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                    
                    }
                    if ($detalle->rete_iva == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Notas Credito';
                        $contabilidad->fecha = $notacredito->fecha;
                        $contabilidad->documento = $notacredito->numero;
                        $contabilidad->documento_ref = $notacredito->factura;
                        $contabilidad->nit = $notacredito->cliente->cedulanit;
                        $contabilidad->detalle = $notacredito->conceptonota->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $notacredito->reteiva;
                        if ($detalle->base == 1){
                            $base = $notacredito->valor;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                  
                    }
                    if ($detalle->total == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Notas Credito';
                        $contabilidad->fecha = $notacredito->fecha;
                        $contabilidad->documento = $notacredito->numero;
                        $contabilidad->documento_ref = $notacredito->factura;
                        $contabilidad->nit = $notacredito->cliente->cedulanit;
                        $contabilidad->detalle = $notacredito->conceptonota->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $notacredito->total;
                        if ($detalle->base == 1){
                            $base = $notacredito->valor;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                  
                    }
                    if ($detalle->base_rete_fuente == 1){
                        $contabilidad = new Contabilidad;
                        $contabilidad->cuenta = $detalle->cuenta;
                        $contabilidad->comprobante = $proceso;
                        $contabilidad->proceso = 'Notas Credito';
                        $contabilidad->fecha = $notacredito->fecha;
                        $contabilidad->documento = $notacredito->numero;
                        $contabilidad->documento_ref = $notacredito->factura;
                        $contabilidad->nit = $notacredito->cliente->cedulanit;
                        $contabilidad->detalle = $notacredito->conceptonota->concepto;
                        $contabilidad->tipo = $detalle->tipocuenta;
                        $contabilidad->valor = $notacredito->valor * $detalle->porcentaje_base / 100;
                        if ($detalle->base == 1){
                            $base = $notacredito->valor;
                        }else{
                            $base = 0;
                        }
                        $contabilidad->base = $base;
                        $contabilidad->centro_costo = '';
                        $contabilidad->transporte = '';
                        $contabilidad->plazo = 0;
                        if ($contabilidad->valor > 0){
                            $contabilidad->save(false);
                        }                
                    }
                }    
            }
        }
        return;            
    }
    
    public function actionExcel($exportar) {                
        $objPHPExcel = new \PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("EMPRESA")
            ->setLastModifiedBy("EMPRESA")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);        
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Id')
                    ->setCellValue('B1', 'Tipo')
                    ->setCellValue('C1', 'Fecha')
                    ->setCellValue('D1', 'Cedula/Nit')
                    ->setCellValue('E1', 'Dv')
                    ->setCellValue('F1', 'Razon Social')
                    ->setCellValue('G1', 'Nombres')
                    ->setCellValue('H1', 'Apellidos')
                    ->setCellValue('I1', 'Nombre Completo')
                    ->setCellValue('J1', 'Departamento')
                    ->setCellValue('K1', 'Municipio')
                    ->setCellValue('L1', 'Direccion')
                    ->setCellValue('M1', 'Telefono')  
                    ->setCellValue('N1', 'celular')
                    ->setCellValue('O1', 'Email')
                    ->setCellValue('P1', 'Contacto')
                    ->setCellValue('Q1', 'Telefono Cont')
                    ->setCellValue('R1', 'Celular Cont')                    
                    ->setCellValue('S1', 'Forma Pago')
                    ->setCellValue('T1', 'Plazo Pago')
                    ->setCellValue('U1', 'Tipo Regimen')
                    ->setCellValue('V1', 'Autoretenedor')
                    ->setCellValue('W1', 'Retencion Iva')
                    ->setCellValue('X1', 'Retencion Fuente')
                    ->setCellValue('Y1', 'Observacion');                    
        $i = 2;
        
        foreach ($tableexcel as $val) {
                                  
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val->idcliente)
                    ->setCellValue('B' . $i, $val->tipo->tipo)
                    ->setCellValue('C' . $i, $val->fechaingreso)
                    ->setCellValue('D' . $i, $val->cedulanit)
                    ->setCellValue('E' . $i, $val->dv)
                    ->setCellValue('F' . $i, $val->razonsocial)
                    ->setCellValue('G' . $i, $val->nombrecliente)
                    ->setCellValue('H' . $i, $val->apellidocliente)
                    ->setCellValue('I' . $i, $val->nombrecorto)
                    ->setCellValue('J' . $i, $val->departamento->departamento)
                    ->setCellValue('K' . $i, $val->municipio->municipio)
                    ->setCellValue('L' . $i, $val->direccioncliente)
                    ->setCellValue('M' . $i, $val->telefonocliente)
                    ->setCellValue('N' . $i, $val->celularcliente)
                    ->setCellValue('O' . $i, $val->emailcliente)
                    ->setCellValue('P' . $i, $val->contacto)
                    ->setCellValue('Q' . $i, $val->telefonocontacto)
                    ->setCellValue('R' . $i, $val->celularcontacto)
                    ->setCellValue('S' . $i, $val->formapago)
                    ->setCellValue('T' . $i, $val->plazopago)
                    ->setCellValue('U' . $i, $val->regimen)
                    ->setCellValue('V' . $i, $val->autoretener)
                    ->setCellValue('W' . $i, $val->retenerfuente)
                    ->setCellValue('X' . $i, $val->reteneriva)
                    ->setCellValue('Y' . $i, $val->observacion);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('cliente');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="cliente.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
        exit;
    }
    
    public function actionContai($exportar) {                
        ob_clean();
        $strArchivo = "plano".".txt";                
        
        $ar = fopen($strArchivo, "a+") or
                die("Problemas en la creacion del archivo plano");                
        /*fputs($ar, "C CUENTA  ");
        fputs($ar, "CTE  ");
        fputs($ar, "FECHADO   ");
        fputs($ar, "DOCUMENTO");
        fputs($ar, "DOC REF  ");
        fputs($ar, "        NIT");
        fputs($ar, "DETALLE                     ");
        fputs($ar, "T");
        fputs($ar, "                VALOR");
        fputs($ar, "               V BASE");
        fputs($ar, "CCOSTO ");
        fputs($ar, "TE ");
        fputs($ar, "PZO");        
        fputs($ar, "\n");*/
        foreach ($exportar as $dato) {
            //$floValor = 0;
            /*if($arRegistroExportar->getTipo() == 1) {
                $floValor = $arRegistroExportar->getDebito();
            } else {
                $floValor = $arRegistroExportar->getCredito();
            }*/
            fputs($ar, str_pad($dato->cuenta, 10));            
            fputs($ar, $this->RellenarNr($dato->comprobante, "0", 5));
            fputs($ar, date("m/d/Y", strtotime($dato->fecha)));
            fputs($ar, $this->RellenarNr($dato->documento, "0", 9));
            fputs($ar, $this->RellenarNr($dato->documento_ref, "0", 9));            
            fputs($ar, $this->RellenarNr($dato->nit, " ", 11));
            fputs($ar, str_pad(utf8_decode($dato->detalle), 28));            
            fputs($ar, $dato->tipo);
            fputs($ar, $this->RellenarNr(round($dato->valor, 2), " ", 21));
            if($dato->base == 0){
                fputs($ar, $this->RellenarNr(round($dato->base, 2), " ", 21));
            }else{
                fputs($ar, $this->RellenarNr(round($dato->base, 2), " ", 21));
            }            
            fputs($ar, "       ");
            fputs($ar, "   ");
            fputs($ar, $this->RellenarNr($dato->plazo, " ", 3));             
            fputs($ar, "\n");
        }
        fclose($ar);

        //$strSql = "TRUNCATE TABLE ctb_registro_exportar";           
        //$em->getConnection()->executeQuery($strSql);                    

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv; charset=ISO-8859-15');
        header('Content-Disposition: attachment; filename='.basename($strArchivo));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($strArchivo));
        readfile($strArchivo);
        unlink($strArchivo);
        exit;
        
    }
    
    public static function RellenarNr($Nro, $Str, $NroCr) {
        $Longitud = strlen($Nro);

        $Nc = $NroCr - $Longitud;
        for ($i = 0; $i < $Nc; $i++)
            $Nro = $Str . $Nro;

        return (string) $Nro;
    }

}
