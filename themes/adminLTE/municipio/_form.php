<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Departamento;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Municipio */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
		'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
	'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                    'options' => []
                ],
	]); ?>
<?php
$departamento = ArrayHelper::map(Departamento::find()->all(), 'iddepartamento', 'departamento');
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h4>Información Municipio</h4>
    </div>
    <div class="panel-body">        														   		
        <div class="row">
            <?= $form->field($model, 'codigomunicipio')->textInput(['maxlength' => true]) ?>    
        </div>
        <div class="row">
            <?= $form->field($model, 'municipio')->textInput(['maxlength' => true]) ?>  					
        </div>

        <div class="row">
            <?= $form->field($model, 'iddepartamento')->dropDownList($departamento,['prompt' => 'Seleccione...']) ?>
        </div>        		
        <div class="panel-footer text-right">            
            <a href="<?= Url::toRoute("municipio/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>		
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
