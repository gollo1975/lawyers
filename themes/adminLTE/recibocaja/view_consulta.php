<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Recibocaja */

$this->title = 'Detalle Recibo de Caja';
$this->params['breadcrumbs'][] = ['label' => 'Recibos de Caja', 'url' => ['indexconsulta']];
$this->params['breadcrumbs'][] = $model->idrecibo;
$view = 'recibocaja';
?>
<div class="recibocaja-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['indexconsulta', 'id' => $model->idrecibo], ['class' => 'btn btn-primary']) ?>        
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
                    <th><?= Html::activeLabel($model, 'idrecibo') ?>:</th>
                    <td><?= Html::encode($model->idrecibo) ?></td>
                    <th><?= Html::activeLabel($model, 'Cliente') ?>:</th>
                    <?php if ($model->idcliente){ ?>
                        <td><?= Html::encode($model->cliente->nombrecorto) ?></td>
                    <?php } else { ?>
                        <td><?= Html::encode($model->clienterazonsocial) ?></td>
                    <?php } ?>
                    
                    <th><?= Html::activeLabel($model, 'idtiporecibo') ?>:</th>
                    <td><?= Html::encode($model->tiporecibo->concepto) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th><?= Html::activeLabel($model, 'idbanco') ?>:</th>
                    <td><?= Html::encode($model->banco->entidad) ?></td>
                    <th><?= Html::activeLabel($model, 'Cuenta') ?>:</th>
                    <td><?= Html::encode($model->banco->producto) ?></td>
                    <th><?= Html::activeLabel($model, 'numero') ?>:</th>
                    <td><?= Html::encode($model->numero) ?></td>                    
                </tr>
                <tr style="font-size: 85%;">
                    <th><?= Html::activeLabel($model, 'fecharecibo') ?>:</th>
                    <td><?= Html::encode($model->fecharecibo) ?></td>
                    <th><?= Html::activeLabel($model, 'Municipio') ?>:</th>
                    <td><?= Html::encode($model->municipio->municipioCompleto) ?></td>
                    <th></th>
                    <td></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th><?= Html::activeLabel($model, 'fechapago') ?>:</th>
                    <td><?= Html::encode($model->fechapago) ?></td>
                    <th><?= Html::activeLabel($model, 'usuariosistema') ?>:</th>
                    <td><?= Html::encode($model->usuariosistema) ?></td>
                    <th><?= Html::activeLabel($model, 'valorpagado') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->valorpagado,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th><?= Html::activeLabel($model, 'observacion') ?>:</th>
                    <td colspan="5"><?= Html::encode($model->observacion) ?></td>

                </tr>
            </table>
        </div>
    </div>
    <div class="table-responsive">
        <div class="panel panel-success ">
            <div class="panel-heading">
                Detalles: <span class="badge"><?= count($modeldetalles)?></span>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Factura Vta</th>
                        <th scope="col">Factura electronica</th>
                        <th scope="col">Rete Fuente</th>
                        <th scope="col">Rete Iva</th>
                        <th scope="col">Valor Abono</th>
                        <th scope="col">Valor Saldo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $calculo = 0; ?>
                    <?php foreach ($modeldetalles as $val): ?>
                        <?php $calculo = $calculo + $val->vlrabono; ?>
                    <tr style="font-size: 85%;">
                        <td><?= $val->iddetallerecibo ?></td>
                        <?php if($val->idfactura){ ?>
                            <td><?= $val->factura->nro_factura ?></td>
                             <td><?= $val->factura->nrofacturaelectronica ?></td>
                        <?php }else{ ?>
                            <td><?= "No Aplica" ?></td>
                        <?php } ?>
                        
                        <td><?= '$ '.number_format($val->retefuente,0) ?></td>
                        <td><?= '$ '.number_format($val->reteiva,0) ?></td>
                        <td><?= '$ '.number_format($val->vlrabono,0) ?></td>
                        <td><?= '$ '.number_format($val->vlrsaldo,0) ?></td>                        
                    </tr>                    
                    </tbody>
                    <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>                                                
                         <td></td>   
                        <td align="right"><b>Total:</b></td>
                        <td><?= '$ '.number_format($calculo,0); ?></td>
                    </tr>
                </table>
            </div>            
        </div>
    </div>
</div>
