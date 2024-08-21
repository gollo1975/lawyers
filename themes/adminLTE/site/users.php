<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;


$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;


?>
<script language="JavaScript">
    function mostrarfiltro() {
        divC = document.getElementById("filtrousuario");
        if (divC.style.display == "none"){divC.style.display = "block";}else{divC.style.display = "none";}
    }
</script>

<!--<h1>Lista Clientes</h1>-->
<?php $formulario = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("site/users"),
    "enableClientValidation" => false,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="panel panel-primary panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtrousuario" style="display:none">
        <div class="row" >
            <?= $formulario->field($form, "nombreusuario")->input("search") ?>
            <?= $formulario->field($form, "documentousuario")->input("search") ?>
            <?= $formulario->field($form, "nombrecompleto")->input("search") ?>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary",]) ?>
            <a align="right" href="<?= Url::toRoute("site/users") ?>" class="btn btn-success"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
        </div>
    </div>
</div>

<?php $formulario->end() ?>

<div class="table-responsive">
<div class="panel panel-primary ">
    <div class="panel-heading">
        Registros: <?= $pagination->totalCount ?>
    </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>                
                <th scope="col" style='background-color:#caf0f8;'>ID</th>
                <th scope="col" style='background-color:#caf0f8;'>USER NAME</th>
                <th scope="col" style='background-color:#caf0f8;'>NOMBRE COMPLETO</th>
                <th scope="col" style='background-color:#caf0f8;'>DOCUMENTO</th>
                <th scope="col" style='background-color:#caf0f8;'>EMAIL</th>
                <th scope="col" style='background-color:#caf0f8;'>PERFIL</th>
                <th scope="col" style='background-color:#caf0f8;'>ESTADO</th>
                <th scope="col" style='background-color:#caf0f8;'></th>                               
                <th scope="col" style='background-color:#caf0f8;'></th>
                <th scope="col" style='background-color:#caf0f8;'></th>
                
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $val): ?>
                <tr style="font-size: 85%;">                
                <td><?= $val->codusuario ?></td>
                <td><?= $val->username ?></td>
                <td><?= $val->nombrecompleto ?></td>
                <td><?= $val->documentousuario ?></td>
                <td><?= $val->emailusuario ?></td>
                <td><?= $val->perfil ?></td>
                <td><?= $val->estado ?></td>
                <td style="width: 25px;">				
                   <a href="<?= Url::toRoute(["site/view", "id" => $val->codusuario]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
                <td style="width: 25px;">				
                  <a href="<?= Url::toRoute(["site/editar", "id" => $val->codusuario])?>" ><span class="glyphicon glyphicon-pencil"></span></a>		
                </td>
                <td style="width: 60px;">				
                  <?= Html::a('Cambio Clave', ["site/changepassword", "id" => $val->codusuario], ['class' => 'btn btn-primary btn-sm' ]) ?>
                </td>
                
            </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
        <div class="panel-footer text-right" >
            <a align="right" href="<?= Url::toRoute("site/register") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Nuevo</a>
           
        </div>
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>







