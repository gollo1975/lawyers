<?php
//modelos

//clases
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
?>
<?php
$form = ActiveForm::begin([
            "method" => "post",
            'id' => 'formulario',
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
            'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
            'fieldConfig' => [
            'template' => '{label}<div class="col-sm-8 form-group">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-sm-4 control-label'],
            'options' => []
        ],
        ]);
$depto = ArrayHelper::map(\app\models\Departamento::find()->orderBy('departamento ASC' )->all(), 'iddepartamento', 'departamento');
$conMunicipio = ArrayHelper::map(\app\models\Municipio::find()->orderBy('municipio ASC' )->all(), 'idmunicipio', 'municipio');
?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
    </div>
    <div class="modal-body">        
        <div class="table table-responsive">
            <div class="panel panel-primary ">
                <div class="panel-heading" style="text-align: left ">
                  NUEVA DIRECCION DEL CLIENTE  
                </div>
                <div class="panel-body">
                     <div class="row">
                        <?= $form->field($model, 'iddepartamento')->dropDownList($depto, ['prompt' => 'Seleccione...', 'required' => 'true']) ?>
                    </div>
                     <div class="row">
                        <?= $form->field($model, 'idmunicipio')->dropDownList($conMunicipio, ['prompt' => 'Seleccione...', 'required' => 'true']) ?>
                    </div>
                    <div class="row">
                         <?= $form->field($model, 'direccion')->textInput(['maxlength' => true, 'size' => 50]) ?>  
                    </div>
                    
                </div>  
                    <div class="panel-footer text-right">
                       <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Enviar", ["class" => "btn btn-primary", 'name' => 'nuevo_contacto_cliente']) ?>                    
                   </div>
                
            </div>
           
        </div>
    </div>
<?php $form->end() ?> 

