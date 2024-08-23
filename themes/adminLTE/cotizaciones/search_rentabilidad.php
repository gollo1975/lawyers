<?php

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

$this->title = 'CONSULTA (RENTABILIDAD)';
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
    "action" => Url::toRoute("cotizaciones/search_rentabilidad"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);
$ConGrupo = ArrayHelper::map(app\models\GrupoReferencia::find()->orderBy('concepto ASC')->all(), 'id_grupo', 'concepto');
$ConCliente = ArrayHelper::map(app\models\Cliente::find()->orderBy('nombrecorto ASC')->all(), 'idcliente', 'nombrecorto');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="panel panel-primary panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtro" style="display:none">
        <div class="row" >
            <?= $formulario->field($form, "codigo")->input("search") ?>
            <?= $formulario->field($form, "referencia")->input("search") ?>
            <?=  $formulario->field($form, 'fecha_inicio')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                           'value' => date('Y-m-d', strtotime('+2 days')),
                           'options' => ['placeholder' => 'Seleccione una fecha ...'],
                           'pluginOptions' => [
                               'format' => 'yyyy-m-d',
                               'todayHighlight' => true]])
            ?>
            <?=  $formulario->field($form, 'fecha_corte')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                           'value' => date('Y-m-d', strtotime('+2 days')),
                           'options' => ['placeholder' => 'Seleccione una fecha ...'],
                           'pluginOptions' => [
                           'format' => 'yyyy-m-d',
                           'todayHighlight' => true]])
            ?>
            <?= $formulario->field($form, 'cliente')->widget(Select2::classname(), [
                'data' => $ConCliente,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            <?= $formulario->field($form, 'grupo')->widget(Select2::classname(), [
                'data' => $ConGrupo,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            <?= $formulario->field($form, "numero")->input("search") ?>
        </div>
        
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute("cotizaciones/search_rentabilidad") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
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
        <?php if($modelo){?>
             Registros: <span class="badge"> <?= $pagination->totalCount ?></span>
        <?php }?>     
    </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style ='font-size:90%;'>                
                <th scope="col" style='background-color:#caf0f8;'>CODIGO</th>
                <th scope="col" style='background-color:#caf0f8;'>REFERENCIA</th>
                 <th scope="col" style='background-color:#caf0f8;'>NR COTIZACION</th>
                <th scope="col" style='background-color:#caf0f8;'>CLIENTE</th>
                <th scope="col" style='background-color:#caf0f8;'>F. COTIZACION</th>
                <th scope="col" style='background-color:#caf0f8;'>UNIDADES</th>
                <th scope="col" style='background-color:#caf0f8;'>VL. COSTO</th>
                <th scope="col" style='background-color:#caf0f8;'>VL. VENTA</th>
                 <th scope="col" style='background-color:#caf0f8;'>GANANCIA</th>
                <th scope="col" style='background-color:#caf0f8;'>M.GANANCIA</th>
                <th scope="col" style='background-color:#caf0f8;'>T.GANANCIA</th>
               
             
            </tr>
            </thead>
            <tbody>
            <?php 
            $renta = 0; $porcentaje = 0;
            if($modelo){ 
                foreach ($modelo as $val):
                    $renta = ($val->valor_unidad - $val->codigoReferencia->costo_producto);
                    $porcentaje = ''.number_format((($renta / $val->valor_unidad)*100),2); 
                    ?>
                    <tr style='font-size:85%;'>    
                        <td><?= $val->codigo ?></td>
                        <td><?= $val->referencia ?></td>
                        <td><?= $val->cotizacion->numero_cotizacion ?></td>
                        <td><?= $val->cotizacion->cliente->nombrecorto ?></td>
                        <td><?= $val->fecha_cotizacion ?></td>
                        <td style="text-align: right"><?= $val->cantidad_referencia ?></td>
                        <td style="text-align: right"><?= '$ '. number_format($val->codigoReferencia->costo_producto,0) ?></td>
                        <td style="text-align: right"><?= '$ '. number_format($val->valor_unidad, 0)?></td>
                        <td style="text-align: right"><?= '$ '. number_format($renta)?></td>
                        <td style="text-align: right"><?= $porcentaje ?> %</td>
                        <td style="text-align: right"><?=''. number_format($renta * $val->cantidad_referencia,0) ?> </td>
                       

                </tbody>            
                <?php endforeach; 
                
            }?>
        </table>    
        <div class="panel-footer text-right" >            
            <?= Html::submitButton("<span class='glyphicon glyphicon-export'></span> Excel", ['name' => 'excel','class' => 'btn btn-primary btn-sm ']); ?>                
        </div>
      <?php $form->end() ?>
    </div>
</div>
<?php if($modelo){?>
<?= LinkPager::widget(['pagination' => $pagination]) ?>
<?php } ?>



