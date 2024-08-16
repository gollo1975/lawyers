<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ordenproducciontipo */

$this->title = 'INSUMOS / SERVICIOS';
$this->params['breadcrumbs'][] = ['label' => 'Insumos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id_insumo;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="insumos-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <p>
               <?php  echo Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']);?>
                 
               </p>  
    <div class="panel panel-primary">
        <div class="panel-heading">
           DETALLE
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'Id') ?></th>
                    <td><?= Html::encode($model->id_insumo) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'Codigo') ?></th>
                    <td><?= Html::encode($model->codigo_insumo) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'Nombre_Insumo') ?>:</th>
                    <td><?= Html::encode($model->nombre_insumo) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'valor_costo') ?></th>
                    <td style="text-align: right;"><?= Html::encode(''.number_format($model->valor_costo,0)) ?></td>
                </tr>
                <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'Medida') ?></th>
                    <td><?= Html::encode($model->medida->medida) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'user_name') ?></th>
                    <td><?= Html::encode($model->user_name) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'fecha_proceso') ?></th>
                    <td><?= Html::encode($model->fecha_proceso) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'id_clasificacion') ?></th>
                    <td style="text-align: right;"><?= Html::encode($model->clasificacion->concepto) ?></td>
                </tr>
            </table>
        </div>
    </div>

</div>
