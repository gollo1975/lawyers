<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\web\Session;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;

/* @var $this yii\web\View */
/* @var $model app\models\Empleado */

$this->title = 'CLIENTES';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->idcliente;

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="clientes-view">

    <!--<?= Html::encode($this->title) ?>-->
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading">
           CLIENTES
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'>Id:</th>
                    <td><?= $model->idcliente ?></td>
                    <th style='background-color:#edf2f4;'>Tipo documento:</th>
                    <td><?= $model->tipo->tipo ?></td>
                    <th style='background-color:#edf2f4;'>Nit/Cedula:</th>
                    <td><?= $model->cedulanit ?>-<?= $model->dv ?></td>
                    <th style='background-color:#edf2f4;' >Cliente:</th>
                    <td><?= $model->nombrecorto ?></td>
                </tr>
                <tr style="font-size: 90%;">
                    
                    <th style='background-color:#edf2f4;'>Telefono:</th>
                    <td><?= $model->telefonocliente ?></td>
                    <th style='background-color:#edf2f4;'>Celular:</th>
                    <td><?= $model->celularcliente ?></td>
                        <th style='background-color:#edf2f4;'>Email:</th>
                    <td><?= $model->emailcliente ?></td>
                       <th style='background-color:#edf2f4;'>Direccion:</th>
                    <td><?= $model->direccioncliente ?></td>
                </tr>
                <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'>Departamento:</th>
                    <td><?= $model->departamento->departamento ?></td>
                    <th style='background-color:#edf2f4;'>Municipio.</th>
                    <td><?= $model->municipio->municipio ?></td>
                    <th style='background-color:#edf2f4;'>Usuario:</th>
                    <td><?= $model->usuario ?></td>
                     <th style='background-color:#edf2f4;'>Fecha hora:</th>
                    <td><?= $model->fechaingreso ?></td>
                </tr>
                <tr style="font-size: 90%;">
                     <th style='background-color:#edf2f4;'>Observación:</th>
                    <td colspan="8"><?= $model->observacion ?></td>
                </tr>
            </table>
        </div>
    </div>
      <?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
    'fieldConfig' => [
        'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-sm-3 control-label'],
        'options' => []
    ],
    ]);?>
    <!--INICIO LOS TABS-->
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <?php
              $contMaquina = 1;
             ?>
            <li role="presentation" class="active"><a href="#contactos" aria-controls="contactos" role="tab" data-toggle="tab">Contactos  <span class="badge"><?= 1 ?></span></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="contactos">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style='font-size:90%;'>
                                        <th scope="col" style='background-color:#edf2f4;'>Id</th>                        
                                        <th scope="col" style='background-color:#edf2f4;'>Nombre contacto</th>                        
                                        <th scope="col" style='background-color:#edf2f4;'>Email</th> 
                                        <th scope="col" style='background-color:#edf2f4;'>Celular</th> 
                                        <th scope="col" style='background-color:#edf2f4;'>F.nacimiento</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>      
                            </table>
                        </div>
                    </div>   
                </div>
            </div>
           
        </div>
    </div> 
    <?php ActiveForm::end(); ?>  
</div>
