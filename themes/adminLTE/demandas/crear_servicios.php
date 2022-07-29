<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = 'Servicios';
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['view','id' => $id]];
$this->params['breadcrumbs'][] = $this->title;

/* @var $this yii\web\View */
/* @var $model app\models\Cesantia */
/* @var $form yii\widgets\ActiveForm */
$tipo = ArrayHelper::map(app\models\Facturaventatipo::find()->orderBy('concepto ASC')->all(), 'id_factura_venta_tipo', 'concepto');
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
        Información de Servicios
    </div>
    <div class="panel-body">  
         <div class="row">
            <?= $form->field($model, 'id_factura_venta_tipo')->widget(Select2::classname(), [
             'data' => $tipo,
             'options' => ['placeholder' => 'Seleccione.... '],
             'pluginOptions' => [
             'allowClear' => true ]]);
            ?>
        </div>
         <div class="row">
          <?= $form->field($model, 'forma_pago')->dropdownList(['0' => 'CONTADO', '1' => 'CRÉDITO'], ['prompt' => 'Seleccione...', 'onchange' => 'fpago()', 'id' => 'formapago']) ?>
        </div>
         <div class="row">
             <?= $form->field($model, 'valor_pagar')->textInput(['maxlength' => true]) ?>  		
        </div>
        <div class="row">
                <div class="field-tblclientes-observaciones_cliente has-success">
                    <?= $form->field($model, 'observacion', ['template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>'])->textarea(['rows' => 3]) ?>
                </div>
        </div> 
        <div class="panel-footer text-right">                
            <a href="<?= Url::toRoute(['demandas/view','id' =>$id]) ?>" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success",]) ?>		
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
