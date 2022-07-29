<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
//modelos
use app\models\AreaJuzgado;
use app\models\Jurisdicion;
use app\models\Circuito;
use app\models\Distrito;
use app\models\Departamento;
use app\models\Municipio;
use app\models\Juez;
$departamento = ArrayHelper::map(Departamento::find()->orderBy('departamento ASC')->all(), 'iddepartamento', 'departamento');
$municipio = ArrayHelper::map(Municipio::find()->orderBy('municipio ASC')->all(), 'idmunicipio', 'municipio');
$distrito = ArrayHelper::map(Distrito::find()->orderBy('nombre_distrito ASC')->all(), 'id_distrito', 'nombre_distrito');
$circuito = ArrayHelper::map(Circuito::find()->orderBy('nombre_circuito ASC')->all(), 'id_circuito', 'nombre_circuito');
$area = ArrayHelper::map(AreaJuzgado::find()->orderBy('area ASC')->all(), 'id_area_juzgado', 'area');
$jueces = ArrayHelper::map(Juez::find()->orderBy('nombre_juez ASC')->all(), 'id_juez', 'nombre_juez');
$jurisdicion = ArrayHelper::map(Jurisdicion::find()->orderBy('jurisdiccion ASC')->all(), 'id_jurisdiccion', 'jurisdiccion');
?>
<?php
$form = ActiveForm::begin([
            "method" => "post",
            'id' => 'formulario',
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
            'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
            'fieldConfig' => [
            'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-sm-1 control-label'],
            'options' => []
        ],
        ]);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        Registros
    </div>
    
    <div class="panel-body">
        <div class="row">
            <?php if($token == 0){?>
                <?= $form->field($model, 'codigo_juzgado')->textInput(['maxlength' => true, 'size' => '15']) ?>
                <?= $form->field($model, 'nombre_juzgado')->textInput(['maxlength' => true, 'size' => '70'])?> 
            <?php }else { ?>
                <?= $form->field($model, 'codigo_juzgado')->textInput(['maxlength' => true, 'size' => '15', 'readonly' => 'false']) ?>
                <?= $form->field($model, 'nombre_juzgado')->textInput(['maxlength' => true, 'size' => '70'])?>
            <?php }?>
        </div>
        <div class="row">
            <?= $form->field($model, 'direccion_juzgado')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'telefono_juzgado')->textInput(['maxlength' => true, 'size' => '10']) ?>  
        </div>
        <div class="row">
            <?= $form->field($model, 'celular_juzgado')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email_juzgado')->textInput(['maxlength' => true]) ?>
        </div>     
        <div class="row">
            <?= $form->field($model, 'iddepartamento')->dropDownList($departamento, [ 'prompt' => 'Seleccione una opcion...', 'onchange' => ' $.get( "' . Url::toRoute('clientes/municipio') . '", { id: $(this).val() } ) .done(function( data ) {
            $( "#' . Html::getInputId($model, 'idmunicipio', ['required', 'class' => 'select-2']) . '" ).html( data ); });']); ?>
            <?= $form->field($model, 'idmunicipio')->dropDownList($municipio, ['prompt' => 'Seleccione una opcion...']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'id_distrito')->widget(Select2::classname(), [
             'data' => $distrito,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
            <?= $form->field($model, 'id_circuito')->widget(Select2::classname(), [
             'data' => $circuito,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
        </div>   
        <div class="row">
            <?= $form->field($model, 'id_jurisdiccion')->widget(Select2::classname(), [
             'data' => $jurisdicion,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
            <?= $form->field($model, 'id_area_juzgado')->widget(Select2::classname(), [
             'data' => $area,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
        </div>   
        <div class="row">
            <?= $form->field($model, 'id_juez')->widget(Select2::classname(), [
             'data' => $jueces,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
            <?= $form->field($model, 'estado_registro')->dropDownList(['0' => 'ACTIVO', '1' => 'INACTIVO'], ['prompt' => 'Seleccione una opcion...']) ?>
        </div>   
        <div class="panel-footer text-right">			
            <a href="<?= Url::toRoute("juzgados/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>
        </div>
    </div>
</div>
<?php $form->end() ?>     

</div>
