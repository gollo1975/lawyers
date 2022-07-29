<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;

$fechaReal = $mes;
if ($fechaReal == '01'){
    $mensaje = 'enero';
}
if ($fechaReal == '02'){
    $mensaje = 'febrero';
}
if ($fechaReal == '03'){
    $mensaje = 'marzo';
}
if ($fechaReal == '04'){
    $mensaje = 'abril';
}
if ($fechaReal == '05'){
    $mensaje = 'mayo';
}
if ($fechaReal == '06'){
    $mensaje = 'junio';
}
if ($fechaReal == '07'){
    $mensaje = 'julio';
}
if ($fechaReal == '08'){
    $mensaje = 'agosto';
}
if ($fechaReal == '09'){
    $mensaje = 'septiembre';
}
if ($fechaReal == '10'){
    $mensaje = 'octubre';
}
if ($fechaReal == '11'){
    $mensaje = 'noviembre';
}
if ($fechaReal == '12'){
    $mensaje = 'diciembre';
}
$this->title = 'Cumpleaños del mes ' .$mensaje . '';
$this->params['breadcrumbs'][] = $this->title;


?>
<script language="JavaScript">
    function mostrarfiltro() {
        divC = document.getElementById("filtrocliente");
        if (divC.style.display == "none"){divC.style.display = "block";}else{divC.style.display = "none";}
    }
</script>

<!--<h1>Lista Clientes</h1>-->
<?php $formulario = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("clientes/cumpleanos"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);
?>

<div class="panel panel-success panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtrocliente" style="display:none">
        <div class="row" >
            <?= $formulario->field($form, 'mes')->dropDownList(['01' => 'ENERO', '02' => 'FEBRERO','03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE'],['prompt' => 'Seleccione el mes...']) ?> 
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute("clientes/cumpleanos") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
        </div>
    </div>
</div>

<?php $formulario->end() ?>

<div class="table-responsive">
<div class="panel panel-success ">
    <div class="panel-heading">
        
    </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>                
                <th scope="col" style='background-color:#B9D5CE;'>Cedula/Nit</th>
                <th scope="col" style='background-color:#B9D5CE;'>Cliente</th>
                <th scope="col"style='background-color:#B9D5CE;'>Teléfono</th>
                <th scope="col"style='background-color:#B9D5CE;'>Celular</th>
                <th scope="col" style='background-color:#B9D5CE;'>Dirección</th>
                <th scope="col" style='background-color:#B9D5CE;'>Depto</th>
                <th scope="col" style='background-color:#B9D5CE;'>Municipio</th>
                <th scope="col" style='background-color:#B9D5CE;'>Email</th>
                <th scope="col" style='background-color:#B9D5CE;'>F. nacimiento</th>
            </tr>
            </thead>
            <tbody>
              <?php
                    $aux = '';
                    foreach ($model as $cliente):
                        $aux = substr($cliente->fecha_nacimiento, 5, 2);
                        if($aux == $fechaReal){?>
                            <tr style="font-size: 85%;">
                                <td><?= $cliente->cedulanit ?></td>
                                <td><?= $cliente->nombrecorto ?></td>
                                <td><?= $cliente->telefonocliente ?></td>
                                <td><?= $cliente->celularcliente ?></td>
                                <td><?= $cliente->direccioncliente ?></td>
                                 <td><?= $cliente->departamento->departamento ?></td>
                                <td><?= $cliente->municipio->municipio ?></td>
                                <td><?= $cliente->emailcliente ?></td>
                                <td><?= $cliente->fecha_nacimiento ?></td> 
                            </tr>
                        <?php }?>  
                <?php endforeach;?>
            </tbody>    
        </table>
        
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>







