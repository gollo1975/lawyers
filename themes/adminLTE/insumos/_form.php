<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\data\Pagination;
use kartik\depdrop\DepDrop;

//model
use app\models\TipoMedida;
use app\models\Impuestos;
use app\models\Proveedor;

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

<?php
$medida = ArrayHelper::map(TipoMedida::find()->orderBy ('medida ASC')->all(), 'id_medida', 'medida');
$ConClasificacion = ArrayHelper::map(app\models\ClasificacionInsumo::find()->all(), 'id_clasificacion', 'concepto');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="panel panel-primary">
    <div class="panel-heading">
       INSUMOS / SERVICIOS
    </div>
    
    <div class="panel-body">
        <div class="row">
            <?= $form->field($model, 'codigo_insumo')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'nombre_insumo')->textInput(['maxlength' => true, 'size' => '30']) ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'id_medida')->widget(Select2::classname(), [
                'data' => $medida,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?> 
            <?= $form->field($model, 'valor_costo')->textInput(['maxlength' => true]) ?>
        </div>        
        
         <div class="row">
             <?= $form->field($model, 'id_clasificacion')->widget(Select2::classname(), [
                'data' => $ConClasificacion,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?> 
            
        </div>    
        <div class="panel-footer text-right">			
            <a href="<?= Url::toRoute("insumos/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>
        </div>
    </div>
</div>
<?php $form->end() ?>     
