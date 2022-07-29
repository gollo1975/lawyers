<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentoEquivalente */

$this->title = 'Detalle Documento Equivalente';
$this->params['breadcrumbs'][] = ['label' => 'Documentos Equivalentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->consecutivo;
?>
<div class="banco-view">

    <!--<?= Html::encode($this->title) ?>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->consecutivo], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->consecutivo], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Esta seguro de eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir', ['imprimir', 'id' => $model->consecutivo], ['class' => 'btn btn-default btn-sm']) ?>
    </p>
    <div class="panel panel-success">
        <div class="panel-heading">
            Documento Equivalente
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'consecutivo') ?></th>
                    <td><?= Html::encode($model->consecutivo) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'fecha') ?></th>
                    <td><?= Html::encode($model->fecha) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'valor') ?></th>
                    <td style="text-align: right"><?= Html::encode(number_format($model->valor)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'identificacion') ?></th>
                    <td><?= Html::encode($model->identificacion) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'nombre_completo') ?></th>
                    <td><?= Html::encode($model->nombre_completo) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'subtotal') ?></th>
                    <td style="text-align: right"><?= Html::encode(number_format($model->subtotal)) ?></td>                    
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'descripcion') ?></th>
                    <td><?= Html::encode($model->descripcion) ?></td>
                    <th style='background-color:#F0F3EF;' align="right"><?= Html::activeLabel($model, 'porcentaje') ?></th>
                    <td ><?= Html::encode($model->porcentaje) ?></td>
                    <th style='background-color:#F0F3EF;' align="right"><?= Html::activeLabel($model, 'retencion_fuente') ?></th>
                    <td style="text-align: right"><?= Html::encode(number_format($model->retencion_fuente)) ?></td>                    
                </tr>                
            </table>
        </div>
    </div>    

</div>
