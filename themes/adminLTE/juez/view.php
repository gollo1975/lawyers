<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Municipio */

$this->title = 'Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Juez', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id_juez;
?>
<div class="juez-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index', 'id' => $model->id_juez], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->id_juez], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->id_juez], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Esta seguro de eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-success">
        <div class="panel-heading">
            registro
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Codigo') ?>:</th>
                    <td><?= Html::encode($model->id_juez) ?></td>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Juez') ?>:</th>
                    <td><?= Html::encode($model->nombre_juez) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'Activo') ?>:</th>
                    <td><?= Html::encode($model->validarjuez) ?></td>                    
                </tr>
              
            </table>
        </div>
    </div>

</div>
