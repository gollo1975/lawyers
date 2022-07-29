<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banco */

$this->title = 'Detalle Banco';
$this->params['breadcrumbs'][] = ['label' => 'Bancos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->idbanco;
?>
<div class="banco-view">

    <!--<?= Html::encode($this->title) ?>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->idbanco], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->idbanco], [
            'class' => 'btn btn-danger btn-sm',
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
               <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'idbanco') ?>:</th>
                    <td><?= Html::encode($model->idbanco) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'nitbanco') ?>:</th>
                    <td><?= Html::encode($model->nitbanco) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'entidad') ?>:</th>
                    <td><?= Html::encode($model->entidad) ?></td>
                </tr>
              <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'direccionbanco') ?>:</th>
                    <td><?= Html::encode($model->direccionbanco) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'telefonobanco') ?>:</th>
                    <td><?= Html::encode($model->telefonobanco) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'producto') ?>:</th>
                    <td><?= Html::encode($model->producto) ?></td>
                </tr>
               <tr style="font-size: 85%;">
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'activo') ?>:</th>
                    <td><?= Html::encode($model->estado) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'numerocuenta') ?>:</th>
                    <td><?= Html::encode($model->numerocuenta) ?></td>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'nitmatricula') ?>:</th>
                    <td><?= Html::encode($model->nitmatricula) ?></td>
                </tr>                                
            </table>
        </div>
    </div>
</div>
