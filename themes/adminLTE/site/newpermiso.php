<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\Matriculados;
use app\models\Inscritos;
use app\models\PagosPeriodo;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Session;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use kartik\date\DatePicker;

$this->title = 'Nuevo Permiso';
?>

<?php $form = ActiveForm::begin([

    'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
    'fieldConfig' => [
        'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-sm-3 control-label'],
        'options' => []
    ],
]); ?>

<?php

if ($mensaje != ""){
    ?> <div class="alert alert-danger"><?= $mensaje ?></div> <?php
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="table table-responsive">
    <div class="panel panel-primary ">
        <div class="panel-heading">
            Permisos
        </div>
        <div class="panel-body">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th scope="col" style='background-color:#caf0f8;'>ID</th>
                    <th scope="col" style='background-color:#caf0f8;'>MODULO</th>
                    <th scope="col" style='background-color:#caf0f8;' >MENU DE OPERACION</th>
                    <th scope="col" style='background-color:#caf0f8;'>PERMISOS</th>                    
                    <th scope="col" style='background-color:#caf0f8;'><input type="checkbox" onclick="marcar(this);"/></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($permisos as $val):
                    if(\app\models\UsuarioDetalle::find()->where(['=','codusuario', $id])->andWhere(['=','id_permiso', $val->id_permiso])->one()){
                        ?>
                        <tr style="font-size: 85%;">                    
                        <td><?= $val->id_permiso ?></td>
                        <td><?= $val->modulo ?></td>
                        <td><?= $val->menu_operacion ?></td>
                        <td><?= $val->permiso ?></td>                    
                        <td><input type="checkbox" name="idpermiso[]" value="<?= $val->id_permiso ?>" disabled = "false" ></td>
                    <?php }else{?>
                        <tr style="font-size: 85%;">                    
                        <td><?= $val->id_permiso ?></td>
                        <td><?= $val->modulo ?></td>
                        <td><?= $val->menu_operacion ?></td>
                        <td><?= $val->permiso ?></td>                    
                        <td><input type="checkbox" name="idpermiso[]" value="<?= $val->id_permiso ?>" ></td>
                    <?php }?>    
                </tr>
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="panel-footer text-right">
            <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['site/view','id' => $id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>

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