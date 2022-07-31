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

$this->title = 'Detalle juzgado';
$this->params['breadcrumbs'][] = ['label' => 'Juzgados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->codigo_juzgado;
$view = 'juzgados';
?>
<div class="operarios-view">

    <!--<?= Html::encode($this->title) ?>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
	<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->codigo_juzgado], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Archivos', ['archivodir/index','numero' => 4, 'codigo' => $model->codigo_juzgado,'view' => $view], ['class' => 'btn btn-default btn-sm']) ?>
    </p>
    <div class="panel panel-success">
        <div class="panel-heading">
            Detalle 
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Código') ?>:</th>
                    <td><?= Html::encode($model->codigo_juzgado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Juzgado') ?>:</th>
                    <td><?= Html::encode($model->nombre_juzgado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Departamento') ?>:</th>
                    <td><?= Html::encode($model->departamento->departamento) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Municipio') ?>:</th>
                    <td><?= Html::encode($model->municipio->municipio) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Distrito') ?>:</th>
                    <td><?= Html::encode($model->distrito->nombre_distrito) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Dirección') ?>:</th>
                    <td><?= Html::encode($model->direccion_juzgado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Teléfono') ?>:</th>
                    <td><?= Html::encode($model->telefono_juzgado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Celular') ?>:</th>
                    <td><?= Html::encode($model->celular_juzgado) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Jurisdicción') ?>:</th>
                    <td><?= Html::encode($model->jurisdiccion->jurisdiccion) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Email') ?>:</th>
                    <td><?= Html::encode($model->email_juzgado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Area') ?>:</th>
                    <td><?= Html::encode($model->areaJuzgado->area) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Usuario') ?>:</th>
                    <td colspan="4"><?= Html::encode($model->usuario) ?></td>
                 
                </tr>
                 <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Activo') ?>:</th>
                    <td><?= Html::encode($model->activo) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Juez') ?>:</th>
                    <td><?= Html::encode($model->juez->nombre_juez) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Fecha_registro') ?>:</th>
                    <td><?= Html::encode($model->fecha_registro) ?></td>
                    <td colspan="3"></td>
                    
                 
                </tr>
            </table>
        </div>
    </div>
    <!--INICIO LOS TABS-->
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#libre" aria-controls="libre" role="tab" data-toggle="tab">Libre <span class="badge"><?= 1 ?></span></a></li>

        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="libre">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    
                                    <!--CODIGO DE COLUMNA-->
                                </thead>
                                <tbody>
                                     <!-- CODIGO DE PARA-->
                                </tbody>      
                            </table>
                        </div>
                    </div>   
                </div>
                <div class="panel-footer text-right"> 
 
               </div>
            </div>
            <!--INICIO EL OTRO TABS -->
        </div>
    </div>    
</div>
