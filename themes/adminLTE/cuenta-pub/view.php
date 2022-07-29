<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CuentaPub */

$this->title = $model->codigo_cuenta;
$this->params['breadcrumbs'][] = ['label' => 'Cuenta Pubs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cuenta-pub-view">

    <!--<?= Html::encode($this->title) ?>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->codigo_cuenta], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->codigo_cuenta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-success">
        <div class="panel-heading">
            Banco
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th><?= Html::activeLabel($model, 'codigo_cuenta') ?>:</th>
                    <td><?= Html::encode($model->codigo_cuenta) ?></td>
                    <th><?= Html::activeLabel($model, 'nombre_cuenta') ?>:</th>
                    <td><?= Html::encode($model->nombre_cuenta) ?></td>
                    <th><?= Html::activeLabel($model, 'permite_movimientos') ?>:</th>
                    <td><?= Html::encode($model->permite_movimientos) ?></td>
                </tr>
                <tr>
                    <th><?= Html::activeLabel($model, 'exige_nit') ?>:</th>
                    <td><?= Html::encode($model->exige_nit) ?></td>
                    <th><?= Html::activeLabel($model, 'exige_centro_costo') ?>:</th>
                    <td><?= Html::encode($model->exige_centro_costo) ?></td>
                    <th></th>
                    <td></td>
                </tr>                                                
            </table>
        </div>
    </div>       

</div>
