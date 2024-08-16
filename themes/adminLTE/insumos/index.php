<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\data\Pagination;
use kartik\depdrop\DepDrop;
//Modelos...
use app\models\TipoMedida;

$this->title = 'INSUMOS / SERVICIOS';
$this->params['breadcrumbs'][] = $this->title;

?>
<script language="JavaScript">
    function mostrarfiltro() {
        divC = document.getElementById("filtro");
        if (divC.style.display == "none"){divC.style.display = "block";}else{divC.style.display = "none";}
    }
</script>

<!--<h1>Lista Facturas</h1>-->
<?php $formulario = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute(["insumos/index"]),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);

$ConClasificacion = ArrayHelper::map(app\models\ClasificacionInsumo::find()->orderBy ('concepto ASC')->all(), 'id_clasificacion', 'concepto');
$medida = ArrayHelper::map(TipoMedida::find()->orderBy ('medida ASC')->all(), 'id_medida', 'medida');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="panel panel-primary panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtro" style="display:block">
        <div class="row" >
            <?= $formulario->field($form, "codigo")->input("search") ?>
            <?= $formulario->field($form, "insumo")->input("search") ?>
            <?= $formulario->field($form, 'clasificacion')->widget(Select2::classname(), [
                'data' => $ConClasificacion,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            <?= $formulario->field($form, 'medida')->widget(Select2::classname(), [
                'data' => $medida,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>    
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute(["insumos/index"]) ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
        </div>
    </div>
</div>

<?php $formulario->end() ?>
<?php
$form = ActiveForm::begin([
                "method" => "post",                            
            ]);
    ?>
<div class="table-responsive">
<div class="panel panel-primary ">
    <div class="panel-heading">
          Registros <span class="badge"><?= $pagination->totalCount ?></span>
    </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style ='font-size: 85%;'>         
                <th scope="col" style='background-color:#caf0f8;'>ID</th>
                <th scope="col" style='background-color:#caf0f8;'>CODIGO</th>
                <th scope="col" style='background-color:#caf0f8;'>NOMBRE INSUMO</th>
                <th scope="col" style='background-color:#caf0f8;'>MEDIDA</th>
                <th scope="col" style='background-color:#caf0f8;'>CLASIFICACION</th>
                <th scope="col" style='background-color:#caf0f8;'>C. UNITARIO</th>
                <th scope="col" style='background-color:#caf0f8;'></th>
                <th score="col" style='background-color:#caf0f8;'></th>                              
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $val): ?>
            <tr style ='font-size: 90%;'>                
                <td><?= $val->id_insumo?></td>
                <td><?= $val->codigo_insumo?></td>
                <td><?= $val->nombre_insumo?></td>
                <td><?= $val->medida->medida?></td>
                <td><?= $val->clasificacion->concepto?></td>
                <td style="text-align: right"><?= ''.number_format($val->valor_costo,0)?></td>
                
                <td style= 'width: 25px; height: 10px;'>
                    <a href="<?= Url::toRoute(["insumos/view", "id" => $val->id_insumo]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
                <td style= 'width: 25px; height: 10px;'>
                    <a href="<?= Url::toRoute(["insumos/update", "id" => $val->id_insumo]) ?>" ><span class="glyphicon glyphicon-pencil"></span></a>                   
                </td>
            </tr>            
            <?php endforeach; ?>
            </tbody>    
        </table> 
        <div class="panel-footer text-right" >            
            <a align="right" href="<?= Url::toRoute("insumos/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Nuevo</a>
        <?php $form->end() ?>
        </div>
     </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>

