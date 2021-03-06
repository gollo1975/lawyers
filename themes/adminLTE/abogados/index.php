<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;


$this->title = 'Abogados';
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
    "action" => Url::toRoute("abogados/index"),
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
            <?= $formulario->field($form, "documento")->input("search") ?>
            <?= $formulario->field($form, "nombrecompleto")->input("search") ?>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute("abogados/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
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
                <th scope="col" style='background-color:#B9D5CE;'>Tipo</th>
                <th scope="col" style='background-color:#B9D5CE;'>Documento</th>
                <th scope="col" style='background-color:#B9D5CE;'>Abogado</th>
                <th scope="col" style='background-color:#B9D5CE;'>Direcci??n</th>
                <th scope="col"style='background-color:#B9D5CE;'>Tel??fono</th>
                <th scope="col" style='background-color:#B9D5CE;'>Email</th>
                 <th scope="col" style='background-color:#B9D5CE;'>Dpto</th>
                <th scope="col" style='background-color:#B9D5CE;'>Municipio</th>
                <th scope="col" style='background-color:#B9D5CE;'><span title="Tarjeta profesional">Tp.</span></th>
                <th scope="col" style='background-color:#B9D5CE;'></th>                               
                <th scope="col" style='background-color:#B9D5CE;'></th>
                <th scope="col" style='background-color:#B9D5CE;'></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $val): ?>
                <tr style="font-size: 85%;">   
                <td><?= $val->tipoDocumento->descripcion ?></td>    
                <td><?= $val->documento ?></td>
                <td><?= $val->nombre_completo ?></td>
                <td><?= $val->direccion_abogado ?></td>
                <td><?= $val->telefono_abogado ?></td>
                <td><?= $val->email_abogado ?></td>
                <td><?= $val->departamento->departamento ?></td>
                <td><?= $val->municipio->municipio ?></td>
                <td><?= $val->tarjeta_profesional ?></td> 
                <td style="width: 25px;">				
                  <a href="<?= Url::toRoute(["abogados/view", "id" => $val->documento]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
                <td style="width: 25px;">
                  <a href="<?= Url::toRoute(["abogados/update", "id" => $val->documento])?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                </td>
                <td style="width: 25px;">
		     <?= Html::a('', ['eliminar', 'id' => $val->documento], [
                        'class' => 'glyphicon glyphicon-trash',
                        'data' => [
                            'confirm' => 'Esta seguro de eliminar el registro?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
        <div class="panel-footer text-right" >
            <a align="right" href="<?= Url::toRoute("abogados/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Nuevo</a>
        </div>
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>







