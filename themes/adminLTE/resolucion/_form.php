<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Resolucion */
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
        <h4>Información Resolución</h4>
    </div>
    <div class="panel-body">
        <div class="row">            
            <?= $form->field($model, 'nroresolucion')->textInput(['maxlength' => true]) ?>
        </div>														   		
        <div class="row">
            <?= $form->field($model, 'desde')->textInput(['maxlength' => true]) ?>    
        </div>
        <div class="row">
            <?= $form->field($model, 'hasta')->textInput(['maxlength' => true]) ?>  					
        </div>
        <div class="row">
            <?=
            $form->field($model, 'fechacreacion')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                'value' => date('d-M-Y', strtotime('+2 days')),
                'options' => ['placeholder' => 'Seleccione una fecha ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true]])
            ?>
        </div>
        <div class="row">
            <?=
            $form->field($model, 'fechavencimiento')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                'value' => date('d-M-Y', strtotime('+2 days')),
                'options' => ['placeholder' => 'Seleccione una fecha ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true]])
            ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'codigoactividad')->textInput(['maxlength' => true]) ?>  					
        </div>
        <div class="row">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>  					
        </div>
        <div class="row">
            <?= $form->field($model, 'activo')->dropdownList(['1' => 'Activo', '0' => 'Inactivo'], ['prompt' => 'Seleccione...']) ?>
        </div>			
        <div class="panel-footer text-right">                    
            <a href="<?= Url::toRoute("resolucion/index") ?>" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success",]) ?>		
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
