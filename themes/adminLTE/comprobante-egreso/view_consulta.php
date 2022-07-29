<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ComprobanteEgreso */

$this->title = 'Detalle Comprobante';
$this->params['breadcrumbs'][] = ['label' => 'Comprobante Egresos', 'url' => ['indexconsulta']];
$this->params['breadcrumbs'][] = $model->id_comprobante_egreso;
$view = 'comprobante-egreso';
?>
<div class="comprobante-egreso-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['indexconsulta', 'id' => $model->id_comprobante_egreso], ['class' => 'btn btn-primary btn-sm']) ?>        
    </p>
    <?php
    if ($mensaje != ""){
        ?> <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $mensaje ?>
    </div> <?php
    }
    ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h5><?= Html::encode($this->title) ?></h5>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'id_comprobante_egreso') ?>:</th>
                    <td><?= Html::encode($model->id_comprobante_egreso) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Proveedor') ?>:</th>
                    <?php if ($model->id_proveedor){ ?>
                        <td><?= Html::encode($model->proveedor->nombrecorto) ?></td>
                    <?php } ?>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'subtotal') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->subtotal,1)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'id_banco') ?>:</th>
                    <td><?= Html::encode($model->banco->entidad) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Cuenta') ?>:</th>
                    <td><?= Html::encode($model->banco->producto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'iva') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->iva,1)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fecha_comprobante') ?>:</th>
                    <td><?= Html::encode($model->fecha_comprobante) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Municipio') ?>:</th>
                    <td><?= Html::encode($model->municipio->municipioCompleto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'rete_fuente') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->retefuente,1)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fecha') ?>:</th>
                    <td><?= Html::encode($model->fecha) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'usuariosistema') ?>:</th>
                    <td><?= Html::encode($model->usuariosistema) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'rete_iva') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->reteiva,1)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'id_comprobante_egreso_tipo') ?>:</th>
                    <td><?= Html::encode($model->comprobanteEgresoTipo->concepto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'numeroComprobante') ?>:</th>
                    <td><?= Html::encode($model->numero) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'base_aiu') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->base_aiu,1)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'observacion') ?>:</th>
                    <td colspan="3"><?= Html::encode($model->observacion) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Total') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->valor,0)) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="table-responsive">
        <div class="panel panel-success ">
            <div class="panel-heading">
                Detalles
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col" style='background-color:#B9D5CE;'>Id</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Factura</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Subtotal</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Iva</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Rete Fuente</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Rete Iva</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Base Aiu</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Valor Abono</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Valor Saldo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $subtotal = 0; ?>
                        <?php $iva = 0; ?>
                        <?php $retefuente = 0; ?>
                        <?php $reteiva = 0; ?>
                        <?php $baseaiu = 0; ?>
                        <?php $calculo = 0; ?>
                    <?php foreach ($modeldetalles as $val): ?>
                        <?php $subtotal = $subtotal + $val->subtotal; ?>
                        <?php $iva = $iva + $val->iva; ?>
                        <?php $retefuente = $retefuente + $val->retefuente; ?>
                        <?php $reteiva = $reteiva + $val->reteiva; ?>
                        <?php $baseaiu = $baseaiu + $val->base_aiu; ?>
                        <?php $calculo = $calculo + $val->vlr_abono; ?>
                    <tr style="font-size: 85%;">
                        <td><?= $val->id_comprobante_egreso_detalle ?></td>
                        <?php if($val->id_compra){ ?>
                            <td><?= $val->compra->factura ?></td>
                        <?php }else{ ?>
                            <td><?= "No Aplica" ?></td>
                        <?php } ?>
                        
                        <td><?= '$ '.  number_format($val->subtotal,1) ?></td>
                            <td><?= '$ '.  number_format($val->iva,1) ?></td>
                            <td><?= '$ '.  number_format($val->retefuente,1) ?></td>
                            <td><?= '$ '.  number_format($val->reteiva,1) ?></td>
                            <td><?= '$ '.  number_format($val->base_aiu,1) ?></td>
                            <td><?= '$ '.  number_format($val->vlr_abono,1) ?></td>
                            <td><?= '$ '.  number_format($val->vlr_saldo,1) ?></td>
                        <?php if ($model->autorizado == 0) { ?>
                            
                        <?php } ?>
                    </tr>                    
                    </tbody>
                    <?php endforeach; ?>
                    <tr><b>
                        <td></td>
                        <td><b>Totales:</td></b>
                        <td align="left"><b><?= '$ '. number_format($subtotal,1); ?></td></b>
                        <td align="left"><b><?= '$ '. number_format($iva,1); ?></td></b>
                        <td align="left"><b><?= '$ '. number_format($retefuente,1); ?></td></b>
                        <td align="left"><b><?= '$ '. number_format($reteiva,1); ?></td></b>
                        <td align="left"><b><?= '$ '. number_format($baseaiu,1); ?></td></b>
                        <td align="left"><b><?= '$ '. number_format($calculo,1); ?></td></b>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
</div>
