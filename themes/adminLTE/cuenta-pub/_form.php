<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\CuentaPub */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
            'fieldConfig' => [
                'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
                'options' => []
            ],
        ]);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        Información Cuenta Pub
    </div>
    <div class="panel-body">        														   		
        <div class="row">
            <?= $form->field($model, 'codigo_cuenta')->textInput(['maxlength' => true]) ?>    
        </div>
        <div class="row">
            <?= $form->field($model, 'nombre_cuenta')->textInput(['maxlength' => true]) ?>  					
        </div>             
        <div class="row">
            <?= $form->field($model, 'permite_movimientos')->dropdownList(['0' => 'NO', '1' => 'Si'], ['prompt' => 'Seleccione...']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'exige_nit')->dropdownList(['0' => 'NO', '1' => 'Si'], ['prompt' => 'Seleccione...']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'exige_centro_costo')->dropdownList(['0' => 'NO', '1' => 'Si'], ['prompt' => 'Seleccione...']) ?>
        </div>
        <div class="panel-footer text-right">			
            <a href="<?= Url::toRoute("cuenta-pub/index") ?>" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success",]) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


