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

$this->title = 'COTIZACIONES';
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
    "action" => Url::toRoute("cotizaciones/index_cotizaciones"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);

$ConCliente = ArrayHelper::map(app\models\Cliente::find()->orderBy('nombrecorto ASC')->all(), 'idcliente', 'nombrecorto');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="panel panel-primary panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtro" style="display:none">
        <div class="row" >
            <?= $formulario->field($form, "numero")->input("search") ?>
             <?= $formulario->field($form, 'cliente')->widget(Select2::classname(), [
                'data' => $ConCliente,
                'options' => ['prompt' => 'Seleccione...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
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
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute("cotizaciones/index_cotizaciones") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
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
        Registros: <span class="badge"> <?= $pagination->totalCount ?></span>
    </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style ='font-size:90%;'>                
                <th scope="col" style='background-color:#caf0f8;'>NUMERO</th>
                 <th scope="col" style='background-color:#caf0f8;'>DOCUMENTO</th>
                <th scope="col" style='background-color:#caf0f8;'>CLIENTE</th>
                <th scope="col" style='background-color:#caf0f8;'>F. COTIZACION</th>
                <th scope="col" style='background-color:#caf0f8;'>F. ENTREGA</th>
                <th scope="col" style='background-color:#caf0f8;'>CANTIDADES</th>
                <th scope="col" style='background-color:#caf0f8;'>SUBTOTAL</th>
                <th scope="col" style='background-color:#caf0f8;'>IVA</th>
                <th scope="col" style='background-color:#caf0f8;'>TOTAL COTIZACION</th>
                <th scope="col" style='background-color:#caf0f8;'></th>
                <th scope="col" style='background-color:#caf0f8;'></th>
              
            </tr>
            </thead>
            <tbody>
            <?php 
             
            foreach ($modelo as $val):?>
                <tr style='font-size:85%;'>                
                    <td><?= $val->numero_cotizacion ?></td>
                     <td><?= $val->cliente->cedulanit ?></td>
                    <td><?= $val->cliente->nombrecorto ?></td>
                    <td><?= $val->fecha_cotizacion ?></td>
                     <td><?= $val->fecha_entrega ?></td>
                    <td style="text-align: right"><?= ''. number_format($val->total_prendas,0) ?></td>
                    <td style="text-align: right"><?= '$'. number_format($val->subtotal,0) ?></td>
                    <td style="text-align: right"><?= '$'. number_format($val->impuesto,0) ?></td>
                    <td style="text-align: right"><?= '$'. number_format($val->total_cotizacion,0) ?></td>
                    <td style= 'width: 25px; height: 25px;'>
                            <a href="<?= Url::toRoute(["cotizaciones/view", "id" => $val->id_cotizacion,'token' => $token]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                    </td>
                    <?php if(!\app\models\CotizacionDetalle::find()->where(['=','id_cotizacion', $val->id_cotizacion])->one()){
                        if($token == 0){  ?>
                            <td style= 'width: 25px; height: 25px;'>
                                    <a href="<?= Url::toRoute(["cotizaciones/update", "id" => $val->id_cotizacion ]) ?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                            </td>
                        <?php }else{?>
                            <td style= 'width: 25px; height: 25px;'></td>
                        <?php }    
                    }else{?>
                        <td style= 'width: 25px; height: 25px;'></td>
                    <?php }?>    
             
            </tbody>            
            <?php endforeach; ?>
        </table>    
        <div class="panel-footer text-right" >            
            <?= Html::submitButton("<span class='glyphicon glyphicon-export'></span> Excel", ['name' => 'excel','class' => 'btn btn-primary btn-sm ']); ?>                
            <a align="right" href="<?= Url::toRoute("cotizaciones/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Nuevo</a>
        </div>
      <?php $form->end() ?>
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>



