<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Departamento;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Municipio */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <?php $form = ActiveForm::begin([
		'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
	'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                    'options' => []
                ],
	]); ?>
<?php
$depto = ArrayHelper::map(Departamento::find()->orderBy('departamento ASC')->all(), 'iddepartamento', 'departamento');
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4>MUNICIPIOS</h4>
    </div>
    <div class="panel-body">        														   		
        <div class="row">
            <?php if($sw == 0){?>
                <?= $form->field($model, 'idmunicipio')->textInput(['maxlength' => true]) ?>  
            <?php }else{?>
                 <?= $form->field($model, 'idmunicipio')->textInput(['maxlength' => true, 'readonly' => true]) ?>  
            <?php }?>
        </div>
        <div class="row">
            <?= $form->field($model, 'municipio')->textInput(['maxlength' => true]) ?>  					
        </div>

        <div class="row">
           <?= $form->field($model, 'iddepartamento')->widget(Select2::classname(), [
                'data' => $depto,
                'options' => ['prompt' => 'Seleccione un registro ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>  
        <div class="row">
             <?= $form->field($model, 'codigomunicipio')->textInput(['maxlength' => true]) ?>  					
        </div>  
        <?php if($sw == 1 ){?>
            <div class="row">
                <?= $form->field($model, 'activo')->dropdownList(['0' => 'NO', '1' => 'SI'], ['prompt' => 'Seleccione...']) ?>
            </div>
        <?php } ?>
        <div class="panel-footer text-right">            
            <a href="<?= Url::toRoute("municipio/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>		
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

