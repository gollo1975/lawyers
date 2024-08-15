<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Pais;
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
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4>DEPARTAMENTOS</h4>
    </div>
    <div class="panel-body">        														   		
        <div class="row">
            <?php if($sw == 1 ){?>
                <?= $form->field($model, 'iddepartamento')->textInput(['maxlength' => true, 'readonly' => true]) ?> 
            <?php }else{?>
            <?= $form->field($model, 'iddepartamento')->textInput(['maxlength' => true]) ?> 
            <?php }?>
        </div>
        <div class="row">
            <?= $form->field($model, 'departamento')->textInput(['maxlength' => true]) ?>  					
        </div>

        <?php if($sw == 1 ){?>
            <div class="row">
                <?= $form->field($model, 'activo')->dropdownList(['0' => 'NO', '1' => 'SI'], ['prompt' => 'Seleccione...']) ?>
            </div>
        <?php } ?>
        <div class="panel-footer text-right">            
            <a href="<?= Url::toRoute("departamento/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>		
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
