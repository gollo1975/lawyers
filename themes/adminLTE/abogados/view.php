<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Municipio;
use app\models\Departamento;
use app\models\TipoDocumento;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
?>

<?php

$this->title = 'Detalle abogado';
$this->params['breadcrumbs'][] = ['label' => 'Abogado', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$view = 'abogados';
?>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $table->documento], ['class' => 'btn btn-success btn-sm']) ?>
    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['eliminar', 'id' => $table->documento], [
        'class' => 'btn btn-danger btn-sm',
        'data' => [
            'confirm' => 'Esta seguro de eliminar el registro?',
            'method' => 'post',
        ],
    ]) ?>
    <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Archivos', ['archivodir/index','numero' => 2, 'codigo' => $table->documento,'view' => $view], ['class' => 'btn btn-default btn-sm']) ?>
</p>

<div class="panel panel-success">
    <div class="panel-heading">
        Información del abogado
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr style="font-size: 85%;">
                <th style='background-color:#F0F3EF;'>Documento:</th>
                <td><?= $table->documento ?></td>
                <th style='background-color:#F0F3EF;'>Tipo documento:</th>
                <td><?= $table->tipoDocumento->descripcion ?></td>
                <th style='background-color:#F0F3EF;'>Nombres:</th>
                <td><?= $table->nombres ?></td>
                <th style='background-color:#F0F3EF;'>Apellidos:</th>
                <td><?= $table->apellidos ?></td>
            </tr>
            <tr style="font-size: 85%;">
            
                <th style='background-color:#F0F3EF;'>Telefono:</th>
                <td><?= $table->telefono_abogado ?></td>
                <th style='background-color:#F0F3EF;'>Fecha_nacimiento:</th>
                <td><?= $table->fecha_nacimiento ?></td>
                <th style='background-color:#F0F3EF;'>Dirección:</th>
                <td><?= $table->direccion_abogado ?></td>
                <th style='background-color:#F0F3EF;'>Email:</th>
                <td><?= $table->email_abogado ?></td>    
            </tr>
            <tr style="font-size: 85%;">
                <th style='background-color:#F0F3EF;'>Usuario:</th>
                <td><?= $table->usuario ?></td>
                <th style='background-color:#F0F3EF;'>Fecha registro:</th>
                <td><?= $table->fecha_registro ?></td>
                <th style='background-color:#F0F3EF;'>Departamento:</th>
                <td><?= $table->departamento->departamento ?></td>
                <th style='background-color:#F0F3EF;' >Municipio:</th>
                <td><?= $table->municipio->municipio ?></td>
            </tr>
            <tr style="font-size: 85%;">
                 <th style='background-color:#F0F3EF;'>Observaciones:</th>
                 <td colspan="7"><?= $table->observacion ?></td>
            </tr>
            
        </table>
    </div>
    
    <!--INICIO LOS TABS-->
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#demandas" aria-controls="demandas" role="tab" data-toggle="tab">Demandas <span class="badge"><?= 1 ?></span></a></li>

        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="demandas">
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

