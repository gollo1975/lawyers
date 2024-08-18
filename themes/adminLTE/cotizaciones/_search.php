<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CotizacionesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cotizaciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_cotizacion') ?>

    <?= $form->field($model, 'id_cliente') ?>

    <?= $form->field($model, 'numero_cotizacion') ?>

    <?= $form->field($model, 'fecha_cotizacion') ?>

    <?= $form->field($model, 'fecha_entrega') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <?php // echo $form->field($model, 'total_prendas') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'impuesto') ?>

    <?php // echo $form->field($model, 'total_cotizacion') ?>

    <?php // echo $form->field($model, 'autorizado') ?>

    <?php // echo $form->field($model, 'proceso_cerrado') ?>

    <?php // echo $form->field($model, 'user_name') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
