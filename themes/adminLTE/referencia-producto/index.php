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

//models
use app\models\TipoProducto;
$this->title = 'REFERENCIA';
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
    "action" => Url::toRoute("referencia-producto/index"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);

$tipoPrenda = ArrayHelper::map(app\models\GrupoReferencia::find()->orderBy('concepto ASC')->all(), 'id_grupo', 'concepto');
?>

<div class="panel panel-primary panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
    <div class="panel-body" id="filtro" style="display:block">
        <div class="row" >
            <?= $formulario->field($form, "codigo")->input("search") ?>
            <?= $formulario->field($form, "referencia")->input("search") ?>
            <?= $formulario->field($form, 'grupo')->widget(Select2::classname(), [
                'data' => $tipoPrenda,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
             <?= $formulario->field($form, "homologado")->input("search") ?>
            <?= $formulario->field($form, "nota_comercial")->input("search") ?>
            <?= $formulario->field($form, "nota_ficha")->input("search") ?>
             <?= $formulario->field($form, 'estado')->dropDownList(['0' => 'NO', '1' => 'SI'],['prompt' => 'Seleccione ...']) ?>
           
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute("referencia-producto/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
        </div>
    </div>
</div>

<?php $formulario->end() ?>

<div class="table-responsive">
<div class="panel panel-primary ">
    <div class="panel-heading">
        Registros: <span class="badge"><?= $pagination->totalCount ?></span>
    </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr style='font-size:85%;'align="center" >     
                <th scope="col" style='background-color:#caf0f8;'>CODIGO</th>
                <th scope="col" style='background-color:#caf0f8;'>REFERENCIA</th>
                <th scope="col" style='background-color:#caf0f8;'>GRUPO</th>
                <th scope="col" style='background-color:#caf0f8;'>COSTO PRODUCTO</th>
                <th scope="col" style='background-color:#caf0f8;'>CODIGO HOMOLOGADO</th>
                <th scope="col" style='background-color:#caf0f8;'>ACTIVO</th>
                <th scope="col" style='background-color:#caf0f8;'></th> 
                <th scope="col" style='background-color:#caf0f8;'></th> 
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $val): ?>
                <tr style='font-size:84%;'>   
                    <td>R-<?= $val->codigo ?></td>
                    <td><?= $val->descripcion_referencia ?></td>
                    <td><?= $val->grupo->concepto ?></td>
                    <td align="right"><?= '$'.number_format($val->costo_producto,0) ?></td>
                    <td><?= $val->codigo_homologado ?></td>
                    <td><?= $val->estadoRegistro ?></td>
                    <!-- Inicio Nuevo Detalle proceso -->
                    <td style= 'width: 25px;'>				
                       <a href="<?= Url::toRoute(["referencia-producto/view", "id" => $val->codigo]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>                
                    </td>
                   
                        <td style= 'width: 25px;'>				
                           <a href="<?= Url::toRoute(["referencia-producto/update", "id" => $val->codigo]) ?>" ><span class="glyphicon glyphicon-pencil"></span></a>                
                        </td>
                   
                </tr>
            </tbody>
            <?php endforeach; ?>
        </table>    
        <div class="panel-footer text-right" >            
            <?php
                $form = ActiveForm::begin([
                            "method" => "post",                            
                        ]);
                ?>    
                <?= Html::submitButton("<span class='glyphicon glyphicon-export'></span> Excel", ['name' => 'excel','class' => 'btn btn-primary btn-sm']); ?>
                <a align="right" href="<?= Url::toRoute("referencia-producto/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Nuevo</a>
            <?php $form->end() ?>
        </div>
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>







