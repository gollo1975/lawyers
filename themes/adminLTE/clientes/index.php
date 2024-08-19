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
use app\models\AgentesComerciales;
use app\models\TipoCliente;


$this->title = 'CLIENTES';
$this->params['breadcrumbs'][] = $this->title;


?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<script language="JavaScript">
    function mostrarfiltro() {
        divC = document.getElementById("filtrocliente");
        if (divC.style.display == "none"){divC.style.display = "block";}else{divC.style.display = "none";}
    }
</script>

<!--<h1>Lista proveedor</h1>-->
<?php $formulario = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("clientes/index"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);
?>

<div class="panel panel-primary panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtrocliente" style="display:block">
        <div class="row" >
            <?= $formulario->field($form, "cedulanit")->input("search") ?>
            <?= $formulario->field($form, "nombre_completo")->input("search") ?>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary",]) ?>
            <a align="right" href="<?= Url::toRoute("clientes/index") ?>" class="btn btn-success"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
        </div>
    </div>
</div>

<?php $formulario->end() ?>

<div class="table-responsive">
<div class="panel panel-primary ">
    <div class="panel-heading">
        <?php if($model){?> 
            Registros <span class="badge"><?= $pagination->totalCount ?></span>
        <?php } ?>     
    </div>
        <table class="table table-bordered table-hover">
            <thead>
           <tr style="font-size: 85%;">    
                <th scope="col" style='background-color:#caf0f8;'>TIPO</th>
                <th scope="col" style='background-color:#caf0f8;'>DOCUMENTO</th>
                <th scope="col" style='background-color:#caf0f8;'>CLIENTE</th>
                <th scope="col" style='background-color:#caf0f8;'>DIRECCION</th>
                <th scope="col" style='background-color:#caf0f8;'>TEFEFONO</th>
                <th scope="col" style='background-color:#caf0f8;'>CELULAR</th>
                <th scope="col" style='background-color:#caf0f8;'>DEPARTAMENTO</th>
                <th scope="col" style='background-color:#caf0f8;'>MUNICIPIO</th>
                <th scope="col" style='background-color:#caf0f8;'></th>  
                <th scope="col" style='background-color:#caf0f8;'></th> 
            </tr>
            </thead>
            <tbody>
            <?php
            if($model){ 
                foreach ($model as $val): ?>
            <tr style="font-size: 90%;">                   
                 <td><?= $val->tipo->tipo ?></td>
                <td><?= $val->cedulanit ?></td>
                <td><?= $val->nombrecorto ?></td>
                <td><?= $val->direccioncliente ?></td>
                <td><?= $val->telefonocliente ?></td>
                <td><?= $val->celularcliente ?></td>
                <td><?= $val->departamento->departamento ?></td>
                <td><?= $val->municipio->municipio ?></td>
                <td style= 'width: 25px; height: 20px;'>
                    <a href="<?= Url::toRoute(["clientes/view", "id" => $val->idcliente, 'token' => $token ]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
                <td style= 'width: 25px; height: 20px;'>
                    <a href="<?= Url::toRoute(["clientes/update", "id" => $val->idcliente])?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                </td>
            </tr>
            </tbody>
            <?php endforeach; 
            }?>
        </table>
        <div class="panel-footer text-right" >
             <?php
                $form = ActiveForm::begin([
                            "method" => "post",                            
                        ]);
                ?> 
             <?php if($model){?> 
                <?= Html::submitButton("<span class='glyphicon glyphicon-export'></span> Exportar excel", ['name' => 'excel','class' => 'btn btn-primary btn-sm']); ?>
                <a align="right" href="<?= Url::toRoute("clientes/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Nuevo</a>
             <?php }else{ ?>     
                <a align="right" href="<?= Url::toRoute("clientes/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Nuevo</a>   
             <?php }?>   
              <?php $form->end() ?>
            
        </div>
    </div>
</div>
 <?php if($model){?> 
   <?= LinkPager::widget(['pagination' => $pagination]) ?>
 <?php } ?> 