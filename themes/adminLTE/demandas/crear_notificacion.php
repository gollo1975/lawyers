<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;

use app\models\TipoActuacion;
$this->title = 'Anotación';
$this->params['breadcrumbs'][] = ['label' => 'Anotacion', 'url' => ['view','id' => $id]];
$this->params['breadcrumbs'][] = $this->title;

/* @var $this yii\web\View */
/* @var $model app\models\Cesantia */
/* @var $form yii\widgets\ActiveForm */
$tipo = ArrayHelper::map(TipoActuacion::find()->orderBy('anotacion ASC')->all(), 'id_tipo', 'anotacion');
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
        Información: Notificación
    </div>
    <div class="panel-body">  
         <div class="row">
           <?=  $form->field($model, 'fecha_actuacion')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                'value' => date('Y-m-d', strtotime('+2 days')),
                'options' => ['placeholder' => 'Seleccione una fecha ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true]])
            ?>
        </div>
         <div class="row">
           <?=  $form->field($model, 'fecha_inicio')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                'value' => date('Y-m-d', strtotime('+2 days')),
                'options' => ['placeholder' => 'Seleccione una fecha ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true]])
            ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'id_tipo')->widget(Select2::classname(), [
             'data' => $tipo,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
        </div>
         <div class="row">
           <?=  $form->field($model, 'fecha_finaliza')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                'value' => date('Y-m-d', strtotime('+2 days')),
                'options' => ['placeholder' => 'Seleccione una fecha ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true]])
            ?>
        </div>
        
         <div class="row">
                <div class="field-tblclientes-observaciones_cliente has-success">
                    <?= $form->field($model, 'anotacion', ['template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>'])->textarea(['rows' => 3]) ?>
                </div>
        </div> 
        <div class="panel-footer text-right">                
            <a href="<?= Url::toRoute(['demandas/view','id' =>$id]) ?>" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success",]) ?>		
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
