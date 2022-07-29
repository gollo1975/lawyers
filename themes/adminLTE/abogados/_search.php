<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AbogadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="abogados-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'documento') ?>

    <?= $form->field($model, 'id_tipo_documento') ?>

    <?= $form->field($model, 'nombres') ?>

    <?= $form->field($model, 'apellidos') ?>

    <?= $form->field($model, 'direccion_abogado') ?>

    <?php // echo $form->field($model, 'telefono_abogado') ?>

    <?php // echo $form->field($model, 'email_abogado') ?>

    <?php // echo $form->field($model, 'iddepartamento') ?>

    <?php // echo $form->field($model, 'idmunicipio') ?>

    <?php // echo $form->field($model, 'tarjeta_profesional') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <?php // echo $form->field($model, 'usuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
