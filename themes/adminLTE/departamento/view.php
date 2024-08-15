<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Municipio */

$this->title = 'DEPARTAMENTOS';
$this->params['breadcrumbs'][] = ['label' => 'Departamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->iddepartamento;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="departamentos-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->iddepartamento], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            DEPARTAMENTOS
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
               <tr style ='font-size:90%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'iddepartamento') ?>:</th>
                    <td><?= Html::encode($model->iddepartamento) ?></td>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'departamento') ?>:</th>
                    <td><?= Html::encode($model->departamento) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'estado') ?>:</th>
                    <td><?= Html::encode($model->estadoRegistro) ?></td>                    
              </tr>
            </table>
        </div>
    </div>

</div>