<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Prendatipo;
use app\models\Producto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\Session;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model app\models\Facturaventadetalle */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Nuevo Tipo Recibo Cuenta';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $formulario = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute(["tipo-recibo/nuevodetalles", 'idtiporecibo' => $idtiporecibo]),
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
    <div class="panel-heading">
        Parametros de entrada
    </div>
	
    <div class="panel-body" id="costodiario">
        <div class="row" >
            <?= $formulario->field($form, "nombre")->input("search") ?>
            <?= $formulario->field($form, "cuenta")->input("search") ?>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary",]) ?>
            <a align="right" href="<?= Url::toRoute(["tipo-recibo/nuevodetalles", 'idtiporecibo' => $idtiporecibo]) ?>" class="btn btn-primary"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
        </div>
    </div>
</div>

<?php $formulario->end() ?>

<?php
$form = ActiveForm::begin([
            "method" => "post",
            'id' => 'formulario',
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
            'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
            'fieldConfig' => [
                'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                'labelOptions' => ['class' => 'col-sm-2 control-label'],
                'options' => []
            ],
        ]);
?>

<?php
if ($mensaje != ""){
    ?> <div class="alert alert-danger"><?= $mensaje ?></div> <?php
}
?>

<div class="table table-responsive">
    <div class="panel panel-success ">
        <div class="panel-heading">
            Nuevo Tipo Recibo Cuenta
        </div>
        <div class="panel-body">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th scope="col">Cuenta</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo (1. Debi / 2. Cred)</th>
                    <th scope="col">Exige Mov</th>
                    <th scope="col">Exige Nit</th>
                    <th scope="col">Exige Centro. C</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cuentas as $val): ?>
                <tr>
                    <?php if ($val->permite_movimientos == 0){$dato1 = "NO";}else{$dato1 = "SI";} ?>
                    <?php if ($val->exige_nit == 0){$dato2 = "NO";}else{$dato2 = "SI";} ?>
                    <?php if ($val->exige_centro_costo == 0){$dato3 = "NO";}else{$dato3 = "SI";} ?>
                    <td><?= $val->codigo_cuenta ?></td>
                    <td><?= $val->nombre_cuenta ?></td>
                    <td><input type="text" name="tipo[]" value="0" required=""></td>
                    <td><?=  $dato1 ?></td>                    
                    <td><?=  $dato2 ?></td>                    
                    <td><?=  $dato3 ?></td>                    
                    <td><input type="hidden" name="codigo_cuenta[]" value="<?= $val->codigo_cuenta ?>"></td>
                </tr>
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="panel-footer text-right">
            <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['tipo-recibo/view', 'id' => $idtiporecibo], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success",]) ?>
        </div>
        
    </div>
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>

<?php $form->end() ?>    

<script type="text/javascript">
	function marcar(source) 
	{
		checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
		for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
		{
			if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
			{
				checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
			}
		}
	}
</script>