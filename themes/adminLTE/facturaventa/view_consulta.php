<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Ordenproducciondetalle;
use yii\helpers\Url;
use yii\web\Session;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;

/* @var $this yii\web\View */
/* @var $model app\models\Facturaventa */

$this->title = 'Detalle de Factura';
$this->params['breadcrumbs'][] = ['label' => 'Consulta Facturas', 'url' => ['indexconsulta']];
$this->params['breadcrumbs'][] = $model->idfactura;
$view = 'facturaventa';
?>
<div class="facturaventa-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['indexconsulta', 'id' => $model->idfactura], ['class' => 'btn btn-primary btn-sm']) ?>        
    </p>
    
    <div class="panel panel-success">
        <div class="panel-heading">
            <h5><?= Html::encode($this->title) ?></h5>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
               <tr style='font-size: 85%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'idfactura') ?></th>
                    <td><?= Html::encode($model->idfactura) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Cliente') ?></th>
                    <td><?= Html::encode($model->cliente->nombrecorto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'nro_demanda') ?></th>
                    <td><?= Html::encode($model->nro_demanda. ' - ' .$model->demanda->claseDemanda->concepto) ?></td>
                </tr>
                <tr style='font-size: 85%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'nro_factura') ?></th>
                    <td><?= Html::encode($model->nro_factura) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'porcentajeiva') ?></th>
                    <td><?= Html::encode($model->porcentajeiva) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'subtotal') ?>:</th>
                    <td style="text-align: right"><?= Html::encode('$ '.number_format($model->subtotal,0)) ?></td>
                </tr>
                <tr style='font-size: 85%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fecha_inicio') ?></th>
                    <td><?= Html::encode($model->fecha_inicio) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'porcentajefuente') ?></th>
                    <td><?= Html::encode($model->porcentajefuente) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'impuestoiva') ?> +</th>
                    <td style="text-align: right"><?= Html::encode('$ '.number_format($model->impuestoiva,0)) ?></td>
                </tr>
                <tr style='font-size: 85%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fecha_vencimiento') ?></th>
                    <td><?= Html::encode($model->fecha_vencimiento) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'porcentajereteiva') ?></th>
                    <td><?= Html::encode($model->porcentajereteiva) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'retencioniva') ?> -</th>
                    <td style="text-align: right"><?= Html::encode('$ '.number_format($model->retencioniva,0)) ?></td>
                </tr>
                <tr style='font-size: 85%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'plazopago') ?></th>
                    <td><?= Html::encode($model->plazopago) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Usuario') ?></th>
                    <td><?= Html::encode($model->usuariosistema) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'retencionfuente') ?> -</th>
                    <td style="text-align: right"><?= Html::encode('$ '.number_format($model->retencionfuente,0)) ?></td>
                </tr>
                <tr style='font-size: 85%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'formapago') ?></th>
                    <td><?= Html::encode($model->formaPago) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'saldo') ?></th>
                    <td style="text-align: right"><?= Html::encode('$ '.number_format($model->saldo,0)) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'totalpagar') ?></th>
                    <td style="text-align: right"><?= Html::encode('$ '.number_format($model->totalpagar,0)) ?></td>
                </tr>
                <tr style='font-size: 85%;'>
                   
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Tipo_factura') ?></th>
                    <td><?= Html::encode($model->tipoFactura->concepto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'nrofacturaelectronica') ?></th>
                    <td colspan="4"><?= Html::encode($model->nrofacturaelectronica) ?></td>    
                </tr>
                <tr style="font-size: 85%;">
                      <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'observacion') ?></th>
                    <td colspan="8"><?= Html::encode($model->observacion) ?></td>
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
                        <th scope="col" style='background-color:#B9D5CE;'>Servicio</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Cantidad</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Vr. Venta</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Subtotal</th>
                        <th style='background-color:#B9D5CE;'></th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($modeldetalles as $val): ?>
                        <tr style="font-size: 85%;">
                        <td><?= $val->id_detalle ?></td>
                        <td><?= $val->facturaVentaTipoS->concepto ?></td>
                        <td><?= $val->cantidad ?></td>
                        <td><?= '$ '.number_format($val->preciounitario,0) ?></td>
                        <td><?= '$ '.number_format($val->total,0) ?></td>                 
                    </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
            </div>            
        </div>
    </div>
</div>
