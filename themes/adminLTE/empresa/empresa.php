<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Departamento;
use app\models\Municipio;
use app\models\TipoRegimen;


/* @var $this yii\web\View */
/* @var $model app\models\Parametros */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'MATRICULA DE EMPRESA';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php
$form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
            'fieldConfig' => [
                'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                'labelOptions' => ['class' => 'col-sm-2 control-label'],
                'options' => []
            ],
        ]);
?>
<?php
$regimen = ArrayHelper::map(TipoRegimen::find()->all(), 'id_tipo_regimen', 'regimen');
$departamento = ArrayHelper::map(Departamento::find()->all(), 'iddepartamento', 'departamento');
$municipio = ArrayHelper::map(Municipio::find()->all(), 'idmunicipio', 'municipio');
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        Información Empresa...
    </div>
    <div class="panel-body">
        <div class="row">
            <?= $form->field($model, 'nitmatricula')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'dv')->textInput(['maxlength' => true]) ?>
        </div>                
        <div class="row">
            <?= $form->field($model, 'razonsocialmatricula')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'id_tipo_regimen')->dropDownList($regimen, ['prompt' => 'Seleccione un regimen...']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'nombrematricula')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'apellidomatricula')->textInput(['maxlength' => true]) ?>
        </div>        
        <div class="row">
            <?= $form->field($model, 'direccionmatricula')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'telefonomatricula')->textInput(['maxlength' => true]) ?>
        </div>        
        <div class="row">
            <?= $form->field($model, 'celularmatricula')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'emailmatricula')->textInput(['maxlength' => true]) ?>
        </div>        
        <div class="row">
            <?= $form->field($model, 'iddepartamento')->dropDownList($departamento, [ 'prompt' => 'Seleccione...', 'onchange' => ' $.get( "' . Url::toRoute('empresa/municipio') . '", { id: $(this).val() } ) .done(function( data ) {
                $( "#' . Html::getInputId($model, 'idmunicipio', ['required', 'class' => 'select-2']) . '" ).html( data ); });']); ?>
            <?= $form->field($model, 'idmunicipio')->dropDownList($municipio, ['prompt' => 'Seleccione...']) ?>
        </div>                
        <div class="row">
            <?= $form->field($model, 'porcentaje_iva')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'nombresistema')->textInput(['maxlength' => true]) ?>
        </div>      
        <div class="row">
            <?= $form->field($model, 'representante_legal')->textInput(['maxlength' => true]) ?> 
              <?= $form->field($model, 'condicion_comercial', ['template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>'])->textarea(['rows' => 4, 'maxlength' => true, 'size' => 250]) ?>
         </div>
        <div class="panel-footer text-right">			                        
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Actualizar", ["class" => "btn btn-primary",]) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
