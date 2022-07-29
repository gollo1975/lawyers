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

$this->title = 'Factura de Venta';
$this->params['breadcrumbs'][] = ['label' => 'Factura de venta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->idfactura;
$view = 'facturaventa';
?>
<div class="facturaventa-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index', 'id' => $model->idfactura], ['class' => 'btn btn-primary btn-sm']) ?>
        <?php if ($model->autorizado == 0) { ?>
            <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Autorizar', ['autorizado', 'id' => $model->idfactura], ['class' => 'btn btn-default btn-sm']); }
        else {
            echo Html::a('<span class="glyphicon glyphicon-remove"></span> Desautorizar', ['autorizado', 'id' => $model->idfactura], ['class' => 'btn btn-default btn-sm']);
            echo Html::a('<span class="glyphicon glyphicon-check"></span> Generar', ['generarnro', 'id' => $model->idfactura], ['class' => 'btn btn-default btn-sm']);
            if (($model->nro_factura > 0)){
                echo Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir', ['imprimir', 'id' => $model->idfactura], ['class' => 'btn btn-default btn-sm']);            
                echo Html::a('<span class="glyphicon glyphicon-folder-open"></span> Archivos', ['archivodir/index','numero' => 21, 'codigo' => $model->idfactura,'view' => $view], ['class' => 'btn btn-default btn-sm']);                                                         
            }
        }
        ?>
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
                Detalle de factura  <span class="badge"><?= count($modeldetalles)?></span>
            </div>
            <div class="panel-body">
                 <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th scope="col" style='background-color:#B9D5CE;'>Id</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Servicio</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Cantidad</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Vr. Venta</th>
                        <th scope="col" style='background-color:#B9D5CE;'>Subtotal</th>
                        <th style='background-color:#B9D5CE;'></th>
                        <th style='background-color:#B9D5CE;'></th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($modeldetalles as $val): ?>
                    <tr style='font-size: 85%;'>
                        <td><?= $val->id_detalle ?></td>
                        <td><?= $val->facturaVentaTipoS->concepto ?></td>
                        <td><?= $val->cantidad ?></td>
                        <td><?= '$ '.number_format($val->preciounitario,0) ?></td>
                        <td><?= '$ '.number_format($val->total,0) ?></td>
                        <?php if ($model->autorizado == 0) { ?>
                        <td style="width: 25px;">
                                <a href="#" data-toggle="modal" data-target="#id_detallefactura2<?= $val->id_detalle ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <!-- Editar modal detalle -->
                                <div class="modal fade" role="dialog" aria-hidden="true" id="id_detallefactura2<?= $val->id_detalle ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Registro No : <?= $val->id_detalle ?></h4>
                                            </div>
                                            <?= Html::beginForm(Url::toRoute("facturaventa/editardetalle"), "POST") ?>
                                            <div class="modal-body">
                                                <div class="panel panel-success btn-sm">
                                                    <div class="panel-heading">
                                                        <h4>Editar</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col-lg-2">
                                                            <label>Cantidad:</label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <input type="text" name="cantidad" value="<?= $val->cantidad ?>" class="form-control" required>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label>Valor unitario:</label>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="preciounitario" value="<?=  $val->preciounitario ?>" class="form-control" required>
                                                        </div>
                                                        <input type="hidden" name="iddetallefactura" value="<?= $val->id_detalle ?>">
                                                        <input type="hidden" name="idfactura" value="<?= $val->idfactura ?>">
                                                        <input type="hidden" name="total" value="<?= $val->total ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class='glyphicon glyphicon-remove'></span> Cerrar</button>
                                                <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-saved"></span> Guardar</button>
                                            </div>
                                            <?= Html::endForm() ?>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </td>
                            <td style="width: 25px;">
                                <!-- Eliminar modal detalle -->
                                <a href="#" data-toggle="modal" data-target="#iddetallefactura<?= $val->id_detalle ?>"><span class="glyphicon glyphicon-trash"></span></a>
                                <div class="modal fade" role="dialog" aria-hidden="true" id="iddetallefactura<?= $val->id_detalle ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Eliminar Detalle</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Realmente desea eliminar el registro Nro: <?= $val->id_detalle ?>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <?= Html::beginForm(Url::toRoute("facturaventa/eliminardetalle"), "POST") ?>
                                                <input type="hidden" name="iddetallefactura" value="<?= $val->id_detalle ?>">
                                                <input type="hidden" name="idfactura" value="<?= $model->idfactura ?>">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove'></span> Cerrar</button>
                                                <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
                                                <?= Html::endForm() ?>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </td>
                        <?php }else{ ?>
                            <td style='width: 25px;'>
                            </td>
                             <td style='width: 25px;'>
                            </td>
                            
                        <?php } ?>
                    </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="panel-footer text-right">
                <?php if($model->autorizado == 0){?>
                     <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Agregar servicio', ['facturaventa/nuevodetalles', 'id' => $model->idfactura, 'nro_demanda' => $model->nro_demanda], ['class' => 'btn btn-success btn-sm']) ?>
                <?php } ?>
            </div>    
        </div>
    </div>
</div>
