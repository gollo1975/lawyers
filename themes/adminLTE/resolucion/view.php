<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Resolucion */

$this->title = 'Detalle Resolución';
$this->params['breadcrumbs'][] = ['label' => 'Resoluciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->idresolucion;
?>
<div class="resolucion-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index', 'id' => $model->idresolucion], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->idresolucion], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->idresolucion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-success">
        <div class="panel-heading">
            Resolución
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th><?= Html::activeLabel($model, 'idresolucion') ?>:</th>
                    <td><?= Html::encode($model->idresolucion) ?></td>                    
                    <th><?= Html::activeLabel($model, 'nroresolucion') ?>:</th>
                    <td><?= Html::encode($model->nroresolucion) ?></td>                    
                </tr>
                <tr>
                    <th><?= Html::activeLabel($model, 'desde') ?>:</th>
                    <td><?= Html::encode($model->desde) ?></td>                    
                    <th><?= Html::activeLabel($model, 'hasta') ?>:</th>
                    <td><?= Html::encode($model->hasta) ?></td>                    
                </tr>
                <tr>
                    <th><?= Html::activeLabel($model, 'fechacreacion') ?>:</th>
                    <td><?= Html::encode($model->fechacreacion) ?></td>                    
                    <th><?= Html::activeLabel($model, 'fechavencimiento') ?>:</th>
                    <td><?= Html::encode($model->fechavencimiento) ?></td>                    
                </tr>
                <tr>
                    <th><?= Html::activeLabel($model, 'codigoactividad') ?>:</th>
                    <td><?= Html::encode($model->codigoactividad) ?></td>                    
                    <th><?= Html::activeLabel($model, 'descripcion') ?>:</th>
                    <td><?= Html::encode($model->descripcion) ?></td>                    
                </tr>
                <tr>
                    <th><?= Html::activeLabel($model, 'activo') ?>:</th>
                    <td><?= Html::encode($model->estado) ?></td>                    
                    <th></th>
                    <td></td>                    
                </tr>
            </table>
        </div>
    </div>     
</div>
