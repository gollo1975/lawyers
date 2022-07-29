<?php


//clases
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
use app\models\Cliente;
use app\models\TipoFactura;

$this->title = 'Factura de venta';
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
    "action" => Url::toRoute("facturaventa/index"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);

$cliente = ArrayHelper::map(Cliente::find()->orderBy('nombrecorto ASC')->all(), 'idcliente', 'nombrecorto');
$tipo_factura = ArrayHelper::map(TipoFactura::find()->orderBy('concepto ASC')->all(), 'tipo_factura', 'concepto');
?>
<div class="panel panel-success panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtro" style="display:none">
        <div class="row" >
            <?= $formulario->field($form, "nro_factura")->input("search") ?>
            <?= $formulario->field($form, 'idcliente')->widget(Select2::classname(), [
               'data' => $cliente,
               'options' => ['prompt' => 'Seleccione...'],
               'pluginOptions' => [
                   'allowClear' => true
               ],
            ]); ?>
             <?= $formulario->field($form, 'fecha_inicio')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Seleccione una fecha ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-m-d',
                        'todayHighlight' => true]])
                ?>
                <?= $formulario->field($form, 'fecha_vencimiento')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Seleccione una fecha ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-m-d',
                        'todayHighlight' => true]])
                ?>   
             <?= $formulario->field($form, 'tipo_factura')->widget(Select2::classname(), [
                   'data' => $tipo_factura,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
               </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute("facturaventa/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
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
<div class="panel panel-success ">
    <div class="panel-heading">
          Registros  <span class="badge"><?= $pagination->totalCount ?></span>
    </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style ='font-size: 85%;'>         
                <th scope="col" style='background-color:#B9D5CE;'>No factura</th>
                <th scope="col" style='background-color:#B9D5CE;'>Tipo factura</th>
                <th scope="col" style='background-color:#B9D5CE;'>Proceso</th>
                <th scope="col" style='background-color:#B9D5CE;'>Cliente</th>
                <th scope="col" style='background-color:#B9D5CE;'>Fecha inicio</th>
                <th scope="col" style='background-color:#B9D5CE;'>Fecha vencimiento</th>
                <th scope="col" style='background-color:#B9D5CE;'>Total pagar</th>
                <th scope="col" style='background-color:#B9D5CE;'>Saldo</th>
                <th scope="col" style='background-color:#B9D5CE;'><span title="Autorizada">Aut</span></th>
                <th scope="col" style='background-color:#B9D5CE;'></th>
                <th scope="col" style='background-color:#B9D5CE;'></th>
                                           
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $val):?>
            <tr style ='font-size: 85%;'>                
                <td><?= $val->nro_factura ?></td>
                <td><?= $val->tipoFactura->concepto ?></td>
                 <td><?= $val->demanda->claseDemanda->concepto ?></td>
                <td><?= $val->cliente->nombrecorto ?></td>
                <td><?= $val->fecha_inicio ?></td>
                <td><?= $val->fecha_vencimiento ?></td>
                <td style="text-align: right"><?= ''.number_format($val->totalpagar,0) ?></td>
                <td style="text-align: right"><?= ''.number_format($val->saldo,0) ?></td>
                 <td><?= $val->autorizadoFactura ?></td>
                <td style= 'width: 23px; height: 23px;'>
                <a href="<?= Url::toRoute(["facturaventa/view", "id" => $val->idfactura]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
                <td style= 'width: 23px; height: 23px;'>
                     <?php if($val->autorizado == 0){?>
                         <a href="<?= Url::toRoute(["facturaventa/update", "id" => $val->idfactura]) ?>" ><span class="glyphicon glyphicon-pencil"></span></a>                   
                     <?php }else{ ?>    
                     <?php }?>    
                </td>
            </tr>            
            <?php endforeach; ?>
            </tbody>    
        </table> 
        <div class="panel-footer text-right" >            
           <?= Html::submitButton("<span class='glyphicon glyphicon-export'></span> Exportar excel", ['name' => 'excel','class' => 'btn btn-primary btn-sm']); ?>                
           <a align="right" href="<?= Url::toRoute("facturaventa/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Crear factura</a> 
           <?php $form->end() ?>
        </div>
     </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>

