<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ContabilidadComprobanteTipo */

$this->title = $model->id_contabilidad_comprobante_tipo;
$this->params['breadcrumbs'][] = ['label' => 'Contabilidad Comprobante Tipo (Exportar)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comprobante-egreso-tipo-view">

    <!--<?= Html::encode($this->title) ?>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->id_contabilidad_comprobante_tipo], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->id_contabilidad_comprobante_tipo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-success">
        <div class="panel-heading">
            Comprobante Contabilidad Tipo (Exportar)
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th><?= Html::activeLabel($model, 'id_contabilidad_comprobante_tipo') ?>:</th>
                    <td><?= Html::encode($model->id_contabilidad_comprobante_tipo) ?></td>
                    <th><?= Html::activeLabel($model, 'tipo') ?>:</th>
                    <td><?= Html::encode($model->tipo) ?></td>
                    <th><?= Html::activeLabel($model, 'codigo') ?>:</th>
                    <td><?= Html::encode($model->codigo) ?></td>
                    <th><?= Html::activeLabel($model, 'estado') ?>:</th>
                    <td><?= Html::encode($model->activo) ?></td>
                </tr>                                                
            </table>
        </div>
    </div>
    

</div>

