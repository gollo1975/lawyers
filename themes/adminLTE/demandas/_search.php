<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DemandasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="demandas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nro_demanda') ?>

    <?= $form->field($model, 'idcliente') ?>

    <?= $form->field($model, 'codigo_juzgado') ?>

    <?= $form->field($model, 'id_clase_demanda') ?>

    <?= $form->field($model, 'id_especialidad') ?>

    <?php // echo $form->field($model, 'documento') ?>

    <?php // echo $form->field($model, 'documento_demandado') ?>

    <?php // echo $form->field($model, 'numero_hojas') ?>

    <?php // echo $form->field($model, 'fecha_presentacion') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <?php // echo $form->field($model, 'usuario') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
