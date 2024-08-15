<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Municipio */

$this->title = 'MUNICIPIOS';
$this->params['breadcrumbs'][] = ['label' => 'Municipios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->idmunicipio;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="municipios-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->idmunicipio], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            MUNICIPIOS
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
               <tr style ='font-size:90%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'idmunicipio') ?>:</th>
                    <td><?= Html::encode($model->idmunicipio) ?></td>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'municipio') ?>:</th>
                    <td><?= Html::encode($model->municipio) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'departamento') ?>:</th>
                    <td><?= Html::encode($model->departamento->departamento) ?></td>                    
              </tr>
                <tr style ='font-size:90%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'codigomunicipio') ?>:</th>
                    <td><?= Html::encode($model->codigomunicipio) ?></td>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'activo') ?>:</th>
                    <td><?= Html::encode($model->activo) ?></td> 
                    <th style='background-color:#F0F3EF;'></th>
                    <td></td>
                </tr>                
            </table>
        </div>
    </div>

</div>
