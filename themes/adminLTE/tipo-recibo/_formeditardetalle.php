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

$this->title = 'Editar Recibo Tipo Cuenta';
?>

<?php $form = ActiveForm::begin([
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
        Información Recibo Tipo Cuenta
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
        <div class="panel-footer text-right">                        
            <a href="<?= Url::toRoute(["tipo-recibo/view", 'id' => $tiporecibocuenta->idtiporecibo]) ?>" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success",]) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>