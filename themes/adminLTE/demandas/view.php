<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
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
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;

/* @var $this yii\web\View */
/* @var $model app\models\Empleado */

$this->title = 'Detalle proceso';
$this->params['breadcrumbs'][] = ['label' => 'Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->nro_demanda;
$view = 'demandas';
?>
<div class="operarios-view">

    <!--<?= Html::encode($this->title) ?>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
	<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->nro_demanda], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Archivos', ['archivodir/index','numero' => 20, 'codigo' => $model->nro_demanda,'view' => $view], ['class' => 'btn btn-default btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-send"></span> Radicado',
                    ['/demandas/generaradicado','id' => $model->nro_demanda],
                    [
                        'title' => 'Generar radicado',
                        'data-toggle'=>'modal',
                        'data-target'=>'#modalgeneraradicado',
                        'class' => 'btn btn-info btn-xs'
                    ])    
                    ?>
             <div class="modal remote fade" id="modalgeneraradicado">
                     <div class="modal-dialog modal-lg-centered">
                         <div class="modal-content"></div>
                     </div>
             </div>
    </p>
    <div class="panel panel-success">
        <div class="panel-heading">
            Detalle 
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Nro') ?>:</th>
                    <td><?= Html::encode($model->nro_demanda) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Radicado') ?>:</th>
                    <td><?= Html::encode($model->radicado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Demandante') ?>:</th>
                    <td><?= Html::encode($model->cliente->nombrecorto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Demandado') ?>:</th>
                    <td><?= Html::encode($model->documentoDemandado->nombre_completo) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Folios') ?>:</th>
                    <td><?= Html::encode($model->numero_hojas) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Fecha_presentacion') ?>:</th>
                    <td><?= Html::encode($model->fecha_presentacion) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Juzgado') ?>:</th>
                    <td><?= Html::encode($model->codigoJuzgado->nombre_juzgado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Especialidad') ?>:</th>
                    <td><?= Html::encode($model->especialidad->especialidad) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Usuario') ?>:</th>
                    <td><?= Html::encode($model->usuario) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Fecha_registro') ?>:</th>
                    <td><?= Html::encode($model->fecha_registro) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Tipo_proceso') ?>:</th>
                    <td><?= Html::encode($model->claseDemanda->concepto) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Juez') ?>:</th>
                    <td><?= Html::encode($model->codigoJuzgado->juez->nombre_juez) ?></td>
                </tr>
                 <tr style="font-size: 85%;">
                     <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Abogado') ?>:</th>
                     <td colspan="3"><?= Html::encode($model->documentoAbogado->nombre_completo) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Observación') ?>:</th>
                    <td colspan="4"><?= Html::encode($model->observacion) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <!--INICIO LOS TABS-->
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#notificacion" aria-controls="notificacion" role="tab" data-toggle="tab">Actuaciones <span class="badge"><?= count($actuacion) ?></span></a></li>
            <li role="presentation"><a href="#servicios" aria-controls="servicios" role="tab" data-toggle="tab">Servicios <span class="badge"><?= count($servicio) ?></span></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="notificacion">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style="font-size: 85%;">
                                        <th scope="col" style='background-color:#B9D5CE;'>Fecha actuación</th>
                                         <th scope="col" style='background-color:#B9D5CE;'>Actuación</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Anotación</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Fecha inicio</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Fecha finaliza</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Fecha registro</th>
                                        <th scope="col" style='background-color:#B9D5CE;'></th>
                                    </tr>    
                                    <!--CODIGO DE COLUMNA-->
                                </thead>
                                <tbody>
                                    <?php foreach ($actuacion as $anotacion):?>
                                        <tr style ='font-size: 85%;'>                
                                            <td><?= $anotacion->fecha_actuacion ?></td>
                                               <td><?= $anotacion->tipo->anotacion ?></td>
                                            <td><?= $anotacion->anotacion ?></td>
                                            <td><?= $anotacion->fecha_inicio ?></td>
                                            <td><?= $anotacion->fecha_finaliza ?></td>
                                            <td><?= $anotacion->fecha_registro ?></td>
                                            <td style=' width: 25px;'>
                                                  <a href="<?= Url::toRoute(["demandas/editar_actuacion",'id' =>$model->nro_demanda,'codigo' => $anotacion->id_actuacion]) ?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                                            </td> 
                                        </tr>    
                                    <?php endforeach;?>
                                </tbody>      
                            </table>
                        </div>
                        <div class="panel-footer text-right">  
                                  <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear actuación', ['demandas/nueva_notificacion', 'id' => $model->nro_demanda], ['class' => 'btn btn-info btn-sm']) ?>                    
                         </div>
                    </div>   
                </div>
            </div>
            <!-- TERMINA TABS -->
             <div role="tabpanel" class="tab-pane" id="servicios">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style="font-size: 85%;">
                                        <th scope="col" style='background-color:#B9D5CE;'>Servicio</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Valor pagar</th>
                                          <th scope="col" style='background-color:#B9D5CE;'>Saldo</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Forma pago</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Fecha registro</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Usuario</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Observación</th>
                                        <th scope="col" style='background-color:#B9D5CE;'></th>
                                    </tr>    
                                    <!--CODIGO DE COLUMNA-->
                                </thead>
                                <tbody>
                                    <?php foreach ($servicio as $val):?>
                                        <tr style ='font-size: 85%;'>                
                                            <td><?= $val->facturaVentaTipo->concepto ?></td>
                                             <td style="text-align: right"><?= ''.number_format($val->valor_pagar, 0) ?></td>
                                            <td style="text-align: right"><?= ''.number_format($val->saldo_servicio, 0) ?></td>
                                            <?php if($val->forma_pago == 0){?>
                                                 <td><?= 'CONTADO' ?></td>
                                            <?php }else{ ?>
                                                 <td><?= 'CREDITO' ?></td>
                                            <?php }?>     
                                            <td><?= $val->fecha_registro ?></td>
                                            <td><?= $val->usuario ?></td>
                                            <td><?= $val->observacion ?></td>
                                            <td style=' width: 25px;'>
                                                  <a href="<?= Url::toRoute(["demandas/editar_servicio",'id' =>$model->nro_demanda,'codigo' => $val->id_servicio]) ?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                                            </td> 
                                        </tr>    
                                    <?php endforeach;?>
                                </tbody>      
                            </table>
                         
                        </div>
                        <div class="panel-footer text-right">  
                                  <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear servicios', ['demandas/crear_servicios', 'id' => $model->nro_demanda], ['class' => 'btn btn-info btn-sm']) ?>                    
                         </div>
                    </div>   
                </div>
            </div>          
            <!-- TERMINA TABS-->
        </div>
    </div>    
</div>
