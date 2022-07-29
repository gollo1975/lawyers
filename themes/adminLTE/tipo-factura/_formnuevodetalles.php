<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\data\Pagination;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Recibocaja */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Nuevo documento';
$this->params['breadcrumbs'][] = ['label' => 'Detalle Factura Venta Tipo', 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = $this->title;?>

<?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal condensed ', 'role' => 'form'],
            'fieldConfig' => [
                'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
                'options' => []
            ],
        ]);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        Información documentos cuenta
    </div>
    <div class="panel-body">        
        <div class="row">            
            <?= $form->field($model, 'cuenta')->widget(Select2::classname(), [
                'data' => $cuentas,
                'options' => ['prompt' => 'Seleccione una cuenta ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'tipocuenta')->dropdownList(['1' => 'DEBITO', '2' => 'CRÉDITO'], ['prompt' => 'Seleccione...']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'base')->dropdownList(['0' => 'NO', '1' => 'SI']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'subtotal')->dropdownList(['0' => 'NO', '1' => 'SI']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'iva')->dropdownList(['0' => 'NO', '1' => 'SI']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'rete_fuente')->dropdownList(['0' => 'NO', '1' => 'SI']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'rete_iva')->dropdownList(['0' => 'NO', '1' => 'SI']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'total')->dropdownList(['0' => 'NO', '1' => 'SI']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'base_rete_fuente')->dropdownList(['0' => 'NO', '1' => 'SI']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'porcentaje_base')->textInput(['maxlength' => true]) ?>  					
        </div>
        <div class="panel-footer text-right">            
            <a href="<?= Url::toRoute(['tipo-factura/view' , 'id' => $id]) ?>" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success",]) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


