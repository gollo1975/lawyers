<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Notacredito;
use yii\helpers\Url;
use yii\web\Session;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Notacreditodetalle;
use app\models\Cliente;
use app\models\Producto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;


/* @var $this yii\web\View */
/* @var $model app\models\Notacredito */

$this->title = 'Detalle Nota de Crédito';
$this->params['breadcrumbs'][] = ['label' => 'Notas Créditos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->idnotacredito;
$view = 'notacredito';
?>
<div class="notacredito-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index', 'id' => $model->idnotacredito], ['class' => 'btn btn-primary btn-sm']) ?>
        <?php if ($model->autorizado == 0) { ?>
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->idnotacredito], ['class' => 'btn btn-success btn-sm']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->idnotacredito], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Esta seguro de eliminar el registro?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Autorizar', ['autorizado', 'id' => $model->idnotacredito], ['class' => 'btn btn-default btn-sm']) ;
        }
            else {
                echo Html::a('<span class="glyphicon glyphicon-remove"></span> Desautorizar', ['autorizado', 'id' => $model->idnotacredito], ['class' => 'btn btn-default btn-sm']);
                echo Html::a('<span class="glyphicon glyphicon-check"></span> Generar', ['notacredito', 'id' => $model->idnotacredito], ['class' => 'btn btn-default btn-sm']);                
                if ($model->numero > 0){
                    echo Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir', ['imprimir', 'id' => $model->idnotacredito], ['class' => 'btn btn-default btn-sm']);            
                    echo Html::a('<span class="glyphicon glyphicon-folder-open"></span> Archivos', ['archivodir/index','numero' => 22, 'codigo' => $model->idnotacredito,'view' => $view], ['class' => 'btn btn-default btn-sm']);                                                         
                }
            }
        ?>
    </p>

    <div class="panel panel-success">
        <div class="panel-heading">
            Nota crédito
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'idnotacredito') ?>:</th>
                    <td><?= Html::encode($model->idnotacredito) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Cliente') ?>:</th>
                    <td><?= Html::encode($model->cliente->nombrecorto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Subtotal') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->valor,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'numero') ?>:</th>
                    <td><?= Html::encode($model->numero) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fecha') ?>:</th>
                    <td><?= Html::encode($model->fecha) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Iva') ?>: +</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->iva,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'autorizado') ?>:</th>
                    <td><?= Html::encode($model->autorizado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'usuariosistema') ?>:</th>
                    <td><?= Html::encode($model->usuariosistema) ?></td>
                    <td style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'ReteIva') ?>: -</th>
                    <td align="right" ><?= Html::encode('$ '.number_format($model->reteiva,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'idconceptonota') ?>:</th>
                    <td><?= Html::encode($model->conceptonota->concepto) ?></td>
                    <th style='background-color:#F0F3EF;'></th>
                    <td ></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'ReteFuente') ?>: -</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->retefuente,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fechapago') ?>:</th>
                    <td><?= Html::encode($model->fechapago) ?></td>
                    <th></th>
                    <td></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Total') ?>:</th>
                    <td align="right"><?= Html::encode('$ '.number_format($model->total,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'observacion') ?>:</th>
                    <td colspan="5"><?= Html::encode($model->observacion) ?></td>
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
                    <tr style="font-size: 85%;">
                        <th style='background-color:#F0F3EF;' scope="col">Id</th>                        
                        <th style='background-color:#F0F3EF;' scope="col">Nro Factura</th>
                        <th style='background-color:#F0F3EF;' scope="col">Cliente</th>
                        <th style='background-color:#F0F3EF;' scope="col">Valor</th>
                        <th style='background-color:#F0F3EF;'></th>
                        <th style='background-color:#F0F3EF;'></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($modeldetalles as $val): ?>
                    <tr style="font-size: 85%;">
                        <td><?= $val->iddetallenota ?></td>                        
                        <td><?= $val->nrofactura ?></td>
                        <td><?= $val->factura->cliente->nombrecorto ?></td>
                        <td><?= '$ '.number_format($val->valor,0) ?></td>
                        <?php if ($model->autorizado == 0) { ?>
                            <td style="width: 25px;">
                                <a href="#" data-toggle="modal" data-target="#iddetallenota2<?= $val->iddetallenota ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <!-- Editar modal detalle -->
                                <div class="modal fade" role="dialog" aria-hidden="true" id="iddetallenota2<?= $val->iddetallenota ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Editar detalle</h4>
                                            </div>
                                            <?= Html::beginForm(Url::toRoute("notacredito/editardetalle"), "POST") ?>
                                            <div class="modal-body">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <h4>Información Nota Crédito Detalle</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col-lg-4">
                                                            <label>Valor:</label>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="valor" value="<?=  $val->valor ?>" class="form-control" required>
                                                        </div>
                                                        <input type="hidden" name="iddetallenota" value="<?= $val->iddetallenota ?>">
                                                        <input type="hidden" name="idnotacredito" value="<?= $val->idnotacredito ?>">
                                                        <input type="hidden" name="total" value="<?= $val->valor ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove'></span> Cerrar</button>
                                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Guardar</button>
                                            </div>
                                            <?= Html::endForm() ?>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </td>
                            <td style="width: 25px;">
                                <!-- Eliminar modal detalle -->
                                <a href="#" data-toggle="modal" data-target="#iddetallenota<?= $val->iddetallenota ?>"><span class="glyphicon glyphicon-trash"></span></a>
                                <div class="modal fade" role="dialog" aria-hidden="true" id="iddetallenota<?= $val->iddetallenota ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Eliminar Detalle</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Realmente deseas eliminar el registro con código <?= $val->iddetallenota ?>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <?= Html::beginForm(Url::toRoute("notacredito/eliminardetalle"), "POST") ?>
                                                <input type="hidden" name="iddetallenota" value="<?= $val->iddetallenota ?>">
                                                <input type="hidden" name="idnotacredito" value="<?= $model->idnotacredito ?>">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove'></span> Cerrar</button>
                                                <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
                                                <?= Html::endForm() ?>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </td>
                        <?php } ?>
                    </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php if ($model->autorizado == 0) { ?>
                <div class="panel-footer text-right">
                    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo', ['notacredito/nuevodetalles', 'idnotacredito' => $model->idnotacredito,'idcliente' => $model->idcliente], ['class' => 'btn btn-success btn-sm']) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['notacredito/editardetalles', 'idnotacredito' => $model->idnotacredito],[ 'class' => 'btn btn-success btn-sm']) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['notacredito/eliminardetalles', 'idnotacredito' => $model->idnotacredito], ['class' => 'btn btn-danger btn-sm']) ?>
                </div>
            <?php } ?>
        </div>
    </div>


</div>