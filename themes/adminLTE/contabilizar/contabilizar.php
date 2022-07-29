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
use app\models\ContabilidadComprobanteTipo;

$this->title = 'Contabilizar';
$this->params['breadcrumbs'][] = $this->title;


?>
<script language="JavaScript">
    function mostrarfiltro() {
        divC = document.getElementById("filtrocontabilizar");
        if (divC.style.display == "none"){divC.style.display = "block";}else{divC.style.display = "none";}
    }
</script>

<!--<h1>Lista Clientes</h1>-->
<?php $formulario = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("contabilizar/contabilizar"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);


$tipos = ArrayHelper::map(ContabilidadComprobanteTipo::find()->all(), 'codigo', 'tipo');
?>

<div class="panel panel-success panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtrocontabilizar" style="display:none">
        <div class="row" >
         
            <?= $formulario->field($form, 'proceso')->dropDownList($tipos, ['prompt' => 'Seleccione un proceso...']) ?>
              <?= $formulario->field($form, 'desde')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                'value' => date('d-M-Y', strtotime('+2 days')),
                'options' => ['placeholder' => 'Seleccione una fecha ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true]])
            ?>
            <?= $formulario->field($form, 'hasta')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                'value' => date('d-M-Y', strtotime('+2 days')),
                'options' => ['placeholder' => 'Seleccione una fecha ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true]])
            ?>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-check'></span> Generar", ["class" => "btn btn-primary",]) ?>            
        </div>
    </div>
</div>

<?php $formulario->end() ?>

<div class="table-responsive">
<div class="panel panel-success ">
    <div class="panel-heading">
        Registros: <?= $pagination->totalCount ?>
    </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>                
                <th scope="col">Cuenta</th>
                <th scope="col">Comprobante</th>
                <th scope="col">proceso</th>
                <th scope="col">Fecha</th>
                <th scope="col">Documento</th>                                               
                <th scope="col">Nit</th>                                               
                <th scope="col">Detalle</th>                                               
                <th scope="col">Tipo</th>                                               
                <th scope="col">Valor</th>   
                <th scope="col">Base</th>   
                <th scope="col">Centro Costo</th>   
                <th scope="col">Transporte</th>   
                <th scope="col">Plazo</th>   
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $val): ?>
            <tr>                                
                <td><?= $val->cuenta ?></td>
                <td><?= $val->comprobante ?></td>
                <td><?= $val->proceso ?></td>
                <td><?= $val->fecha ?></td>
                <td><?= $val->documento ?></td>
                <td><?= $val->nit ?></td>
                <td><?= $val->detalle ?></td>
                <td><?= $val->tipo ?></td>
                <td><?= $val->valor ?></td>
                <td><?= $val->base ?></td>
                <td><?= $val->centro_costo ?></td>
                <td><?= $val->transporte ?></td>
                <td><?= $val->plazo ?></td>
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
                <?= Html::submitButton("<span class='glyphicon glyphicon-export'></span> Exportar", ['name' => 'contai','class' => 'btn btn-primary ']); ?>
            <?php $form->end() ?>
        </div>
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>







