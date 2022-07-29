<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\web\Session;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;

/* @var $this yii\web\View */
/* @var $model app\models\Facturaventa */

$this->title = 'Detalle Compra';
$this->params['breadcrumbs'][] = ['label' => 'Consulta Compras', 'url' => ['indexconsulta']];
$this->params['breadcrumbs'][] = $model->id_compra;
$view = 'facturaventa';
?>
<div class="compra-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['indexconsulta', 'id' => $model->id_compra], ['class' => 'btn btn-primary']) ?>        
    </p>
    
    <div class="panel panel-success">
        <div class="panel-heading">
            <h5><?= Html::encode($this->title) ?></h5>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'id_compra') ?>:</th>
                    <td><?= Html::encode($model->id_compra) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Proveedor') ?>:</th>
                    <td><?= Html::encode($model->proveedor->nombrecorto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'subtotal') ?>:</th>
                    <td><?= Html::encode('$ '.number_format($model->subtotal,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'concepto') ?>:</th>
                    <td><?= Html::encode($model->compraConcepto->concepto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'porcentajeAiu') ?>:</th>
                    <td><?= Html::encode($model->porcentajeaiu) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'baseAiu') ?>:</th>
                    <td><?= Html::encode('$ '.number_format($model->base_aiu,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'factura') ?>:</th>
                    <td><?= Html::encode($model->factura) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'porcentajeiva') ?>:</th>
                    <td><?= Html::encode($model->porcentajeiva) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'impuestoiva') ?>: +</th>
                    <td><?= Html::encode('$ '.number_format($model->impuestoiva,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'numero') ?>:</th>
                    <td><?= Html::encode($model->numero) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'porcentajereteiva') ?>:</th>
                    <td><?= Html::encode($model->porcentajereteiva) ?></td>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'retencioniva') ?>: -</th>
                    <td><?= Html::encode('$ '.number_format($model->retencioniva,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fechainicio') ?>:</th>
                    <td><?= Html::encode($model->fechainicio) ?></td>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'porcentajefuente') ?>:</th>
                    <td><?= Html::encode($model->porcentajefuente) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'retencionfuente') ?>: -</th>
                    <td><?= Html::encode('$ '.number_format($model->retencionfuente,0)) ?></td>
                </tr> 
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fechavencimiento') ?>:</th>
                    <td><?= Html::encode($model->fechavencimiento) ?></td>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'usuariosistema') ?>:</th>
                    <td><?= Html::encode($model->usuariosistema) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'total') ?>:</th>
                    <td><?= Html::encode('$ '.number_format($model->total,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                     <th><?= Html::activeLabel($model, 'id_tipo_compra') ?>:</th>
                    <td><?= Html::encode($model->tipoCompra->descripcion) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'observacion') ?>:</th>
                    <td colspan="4"><?= Html::encode($model->observacion) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <!--COMIENZA EL TABS-->
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <?php
             $con = count($comprobante_pago);
             ?>
            <li role="presentation" class="active"><a href="#comprobantepago" aria-controls="comprobantepago" role="tab" data-toggle="tab">Comprobantes <span class="badge"><?= $con ?></span></a></li>
       </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="comprobantepago">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style='font-size:85%;'>
                                        <tr>                
                                            <th scope="col" style='background-color:#B9D5CE;'>Id_Compra</th>
                                            <th scope="col" style='background-color:#B9D5CE;'>Id_Comprobante</th>
                                             <th scope="col" style='background-color:#B9D5CE;'>Numero</th>                
                                            <th scope="col" style='background-color:#B9D5CE;'>Tipo Pago</th>
                                            <th scope="col" style='background-color:#B9D5CE;'>F. Pago</th>                
                                            <th scope="col" style='background-color:#B9D5CE;'>Vr. Pago</th>                
                                            <th scope="col" style='background-color:#B9D5CE;'>Usuario</th>  
                                            <th scope="col" style='background-color:#B9D5CE;'></th>                               
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comprobante_pago as $val): ?>
                                        <tr style="font-size: 85%;">                
                                            <td><?= $val->id_compra ?></td>
                                             <td><?= $val->id_comprobante_egreso ?></td>
                                             <td><?= $val->comprobanteEgreso->numero ?></td>
                                            <td><?= $val->comprobanteEgreso->comprobanteEgresoTipo->concepto ?></td>  
                                             <td><?= $val->comprobanteEgreso->fecha_comprobante ?></td>     
                                             <td style="text-align: right;"><?= ''.number_format($val->vlr_abono,0) ?></td>
                                             <td><?= $val->comprobanteEgreso->usuariosistema ?></td> 
                                            <td style="width: 25px;">				
                                                <a href="<?= Url::toRoute(["imprimir",'id'=>$val->id_comprobante_egreso]) ?>" ><span class="glyphicon glyphicon-print" title="Imprimir "></span></a>
                                            </td>
                                       </tr>
                                    <?php endforeach; ?>
                                </tbody>       
                            </table>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
    
    
</div>
