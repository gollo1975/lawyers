<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JuzgadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="juzgados-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'codigo_juzgado') ?>

    <?= $form->field($model, 'nombre_juzgado') ?>

    <?= $form->field($model, 'direccion_juzgado') ?>

    <?= $form->field($model, 'telefono_juzgado') ?>

    <?= $form->field($model, 'celular_juzgado') ?>

    <?php // echo $form->field($model, 'email_juzgado') ?>

    <?php // echo $form->field($model, 'iddepartamento') ?>

    <?php // echo $form->field($model, 'idmunicipio') ?>

    <?php // echo $form->field($model, 'id_distrito') ?>

    <?php // echo $form->field($model, 'id_circuito') ?>

    <?php // echo $form->field($model, 'id_jurisdiccion') ?>

    <?php // echo $form->field($model, 'id_area_juzgado') ?>

    <?php // echo $form->field($model, 'usuario') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <?php // echo $form->field($model, 'estado_registro') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
