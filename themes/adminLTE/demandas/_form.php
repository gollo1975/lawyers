<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
//modelos
use app\models\Cliente;
use app\models\Juzgados;
use app\models\ClasesDemandas;
use app\models\Especialidades;
use app\models\Abogados;
use app\models\Demandados;
$cliente = ArrayHelper::map(Cliente::find()->orderBy('nombrecorto ASC')->all(), 'idcliente', 'nombrecorto');
$juzgado = ArrayHelper::map(Juzgados::find()->orderBy('nombre_juzgado ASC')->all(), 'codigo_juzgado', 'nombre_juzgado');
$claseDemanda = ArrayHelper::map(ClasesDemandas::find()->orderBy('concepto ASC')->all(), 'id_clase_demanda', 'concepto');
$especialidad = ArrayHelper::map(Especialidades::find()->orderBy('especialidad ASC')->all(), 'id_especialidad', 'especialidad');
$abogado = ArrayHelper::map(Abogados::find()->orderBy('nombre_completo ASC')->all(), 'documento', 'nombre_completo');
$demandado = ArrayHelper::map(Demandados::find()->orderBy('nombre_completo ASC')->all(), 'documento', 'nombre_completo');
?>
<?php
$form = ActiveForm::begin([
            "method" => "post",
            'id' => 'formulario',
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
            'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
            'fieldConfig' => [
            'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
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
            <?= $form->field($model, 'idcliente')->widget(Select2::classname(), [
             'data' => $cliente,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
            <?= $form->field($model, 'id_clase_demanda')->widget(Select2::classname(), [
             'data' => $claseDemanda,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
        </div>   
        <div class="row">
            <?= $form->field($model, 'codigo_juzgado')->widget(Select2::classname(), [
             'data' => $juzgado,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
            <?= $form->field($model, 'id_especialidad')->widget(Select2::classname(), [
             'data' => $especialidad,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
        </div>   
         <div class="row">
            <?= $form->field($model, 'documento')->widget(Select2::classname(), [
             'data' => $abogado,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
            <?= $form->field($model, 'documento_demandado')->widget(Select2::classname(), [
             'data' => $demandado,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
        </div>   
        <div class="row">
            <?= $form->field($model, 'numero_hojas')->textInput(['maxlength' => true]) ?>
            <?=  $form->field($model, 'fecha_presentacion')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                'value' => date('Y-m-d', strtotime('+2 days')),
                'options' => ['placeholder' => 'Seleccione una fecha ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true]])
            ?>
        </div>    
        <div class="row">
                <div class="field-tblclientes-observaciones_cliente has-success">
                    <?= $form->field($model, 'observacion', ['template' => '{label}<div class="col-sm-10 form-group">{input}{error}</div>'])->textarea(['rows' => 3]) ?>
                </div>
        </div>    
        <div class="panel-footer text-right">			
            <a href="<?= Url::toRoute("demandas/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>
        </div>
    </div>
</div>
<?php $form->end() ?>     

</div>
