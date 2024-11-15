<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\GrupoReferencia;


/* @var $this yii\web\View */
/* @var $model app\models\Municipio */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
		'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
	'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],
	]); ?>
<?php
$tipoPrenda = ArrayHelper::map(GrupoReferencia::find()->orderBy('concepto ASC')->all(), 'id_grupo', 'concepto');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4>Registros</h4>
    </div>
    <div class="panel-body">        														   		
        <div class="row">
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true, 'readonly' => true]) ?>    
            <?= $form->field($model, 'descripcion_referencia')->textInput(['maxlength' => true]) ?>  					
        </div>

        <div class="row">
          <?= $form->field($model, 'id_grupo')->widget(Select2::classname(), [
                'data' => $tipoPrenda,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
             <?= $form->field($model, 'codigo_homologado')->textInput(['maxlength' => true]) ?> 
        </div>
         <div class = "row">
               <?= $form->field($model, 'nota_comercial', ['template' => '{label}<div class="col-sm-10 form-group">{input}{error}</div>'])->textarea(['rows' => 3, 'maxlength' => true, 'size' => 200]) ?>
        </div>
        <div class = "row">
               <?= $form->field($model, 'descripcion', ['template' => '{label}<div class="col-sm-10 form-group">{input}{error}</div>'])->textarea(['rows' => 17, 'maxlength' => true]) ?>
        </div>
        
        <div class="panel-footer text-right">            
            <a href="<?= Url::toRoute("referencia-producto/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-circle-arrow-left '></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>		
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
