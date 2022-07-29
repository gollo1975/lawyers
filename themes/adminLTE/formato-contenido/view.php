<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\GrupoPago */

$this->title = 'Vista';
$this->params['breadcrumbs'][] = ['label' => 'Formato-contenido', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id_formato_contenido;
$view = 'grupo_pago';
?>
<div class="grupo-pago-view">
<!--<?= Html::encode($this->title) ?>-->
      <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index', 'id' => $model->id_formato_contenido], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->id_formato_contenido], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->id_formato_contenido], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-success">
        <div class="panel-heading">
            Formatos-Contenidos
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th><?= Html::activeLabel($model, 'id_formato_contenido') ?>:</th>
                    <td><?= Html::encode($model->id_formato_contenido) ?></td>
                    <th><?= Html::activeLabel($model, 'nombre_formato') ?>:</th>
                    <td><?= Html::encode($model->nombre_formato) ?></td>
                    <th><?= Html::activeLabel($model, 'fecha_creacion') ?>:</th>
                    <td><?= Html::encode($model->fecha_creacion) ?></td>
                    <th><?= Html::activeLabel($model, 'usuariosistema') ?>:</th>
                    <td><?= Html::encode($model->usuariosistema) ?></td>
                    
                </tr>                
               
                <tr>
                    <th><?= Html::activeLabel($model, 'contenido') ?>:</th>
                    <td colspan="8"><?= Html::encode($model->contenido) ?></td>                    
                </tr>
            </table>
        </div>
    </div>
    <?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
    'fieldConfig' => [
        'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-sm-3 control-label'],
        'options' => []
    ],
    ]); ?>        
    <?php ActiveForm::end(); ?>
</div>