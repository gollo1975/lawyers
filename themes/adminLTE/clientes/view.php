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
        <?php if($token == 0){
            echo Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']);
        }else{
            echo Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index_consulta'], ['class' => 'btn btn-primary btn-sm']);
        }?>    
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
            <li role="presentation" class="active"><a href="#contactos" aria-controls="contactos" role="tab" data-toggle="tab">Contactos  <span class="badge"><?= count($Concontacto) ?></span></a></li>
            <li role="presentation" ><a href="#direcciones" aria-controls="direcciones" role="tab" data-toggle="tab">Dirección de envios  <span class="badge"><?= count($ConDireccion) ?></span></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="contactos">
                <div class="table-responsive">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style='font-size:90%;'>
                                        <th scope="col" style='background-color:#caf0f8;'>ID</th>                        
                                        <th scope="col" style='background-color:#caf0f8;'>NOMBRES</th>                        
                                        <th scope="col" style='background-color:#caf0f8;'>APELLIDOS</th>                        
                                        <th scope="col" style='background-color:#caf0f8;'>CELULAR</th> 
                                         <th scope="col" style='background-color:#caf0f8;'>EMAIL</th> 
                                        <th scope="col" style='background-color:#caf0f8;'>F. NACIMIENTO</th> 
                                        <th scope="col" style='background-color:#caf0f8;'>CARGO</th> 
                                        <th scope="col" style='background-color:#caf0f8;'>PRE.</th> 
                                        <th scope="col" style='background-color:#caf0f8;'></th> 
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                        foreach ($Concontacto as $val):?>
                                            <tr style='font-size:90%;'>
                                                 <td> <?= $val->id_contacto?></td>
                                                <td> <?= $val->nombres?></td>
                                                <td> <?= $val->apellidos?></td>
                                                <td> <?= $val->celular?></td>
                                                <td> <?= $val->email?></td>
                                                <td> <?= $val->fecha_nacimiento?></td>
                                                <td> <?= $val->cargo->cargo?></td> 
                                                <td> <?= $val->predeterminadoRegistro?></td> 
                                                 <?php if($token == 0){?>
                                                    <td style= 'width: 25px; height: 20px;'>
                                                       <!-- Inicio Nuevo Detalle proceso -->
                                                          <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                                              ['/clientes/editar_contacto','id' => $model->idcliente, 'token' =>$token, 'detalle' => $val->id_contacto],
                                                              [
                                                                  'title' => 'Editar los contactos del cliente',
                                                                  'data-toggle'=>'modal',
                                                                  'data-target'=>'#modaleditarcontacto'.$model->idcliente,
                                                              ])    
                                                         ?>
                                                        <div class="modal remote fade" id="modaleditarcontacto<?= $model->idcliente ?>">
                                                            <div class="modal-dialog modal-lg" style ="width: 530px;">
                                                                 <div class="modal-content"></div>
                                                            </div>
                                                        </div> 
                                                    </td>   
                                                <?php }else{?>
                                                    <td style= 'width: 25px; height: 20px;'></td>
                                                <?php }?>    
                                            </tr>
                                     <?php endforeach;?>
                                </tbody>      
                            </table>
                        </div>
                        <?php if($token == 0){?>
                            <div class="panel-footer text-right" >  
                                <!-- Inicio Nuevo Detalle proceso -->
                                  <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear contactos',
                                      ['/clientes/new_contacto','id' => $model->idcliente, 'token' =>$token],
                                      [
                                          'title' => 'Crea los contactos del cliente',
                                          'data-toggle'=>'modal',
                                          'data-target'=>'#modalcrearcontacto'.$model->idcliente,
                                          'class' => 'btn btn-success btn-sm'
                                      ])    
                                 ?>
                                <div class="modal remote fade" id="modalcrearcontacto<?= $model->idcliente ?>">
                                    <div class="modal-dialog modal-lg" style ="width: 530px;">
                                         <div class="modal-content"></div>
                                    </div>
                                </div> 
                            </div>   
                        <?php }?>
                    </div>   
                </div>
            </div>
            <!--TERMINA TABS CONTACTOS--->
            <div role="tabpanel" class="tab-pane" id="direcciones">
                <div class="table-responsive">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style='font-size:90%;'>
                                        <th scope="col" style='background-color:#caf0f8;'>ID</th>                        
                                        <th scope="col" style='background-color:#caf0f8;'>DIRECCION</th>                        
                                        <th scope="col" style='background-color:#caf0f8;'>DEPARAMENTO</th>                        
                                        <th scope="col" style='background-color:#caf0f8;'>MUNICIPIO</th> 
                                        <th scope="col" style='background-color:#caf0f8;'></th> 
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                        foreach ($ConDireccion as $val):?>
                                            <tr style='font-size:90%;'>
                                                 <td> <?= $val->id_direccion?></td>
                                                <td> <?= $val->nueva_direccion?></td>
                                                <td> <?= $val->departamento->departamento?></td>
                                                <td> <?= $val->municipio->municipio?></td>
                                                 <?php if($token == 0){?>
                                                    <td style= 'width: 25px; height: 20px;'>
                                                       <!-- Inicio Nuevo Detalle proceso -->
                                                          <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                                              ['/clientes/editar_direccion','id' => $model->idcliente, 'token' =>$token, 'id_detalle' => $val->id_direccion],
                                                              [
                                                                  'title' => 'Editar las direcciones de envio cliente',
                                                                  'data-toggle'=>'modal',
                                                                  'data-target'=>'#modaleditardireccion'.$model->idcliente,
                                                              ])    
                                                         ?>
                                                        <div class="modal remote fade" id="modaleditardireccion<?= $model->idcliente ?>">
                                                            <div class="modal-dialog modal-lg" style ="width: 580px;">
                                                                 <div class="modal-content"></div>
                                                            </div>
                                                        </div> 
                                                    </td>   
                                                <?php }else{?>
                                                    <td style= 'width: 25px; height: 20px;'></td>
                                                <?php }?>    
                                            </tr>
                                     <?php endforeach;?>
                                </tbody>      
                            </table>
                        </div>
                        <?php if($token == 0){?>
                            <div class="panel-footer text-right" >  
                                <!-- Inicio Nuevo Detalle proceso -->
                                  <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear direcciones',
                                      ['/clientes/new_direccion','id' => $model->idcliente, 'token' =>$token],
                                      [
                                          'title' => 'Crea las nuevas direcciones de envio',
                                          'data-toggle'=>'modal',
                                          'data-target'=>'#modalcreardirecciones'.$model->idcliente,
                                          'class' => 'btn btn-warning btn-sm'
                                      ])    
                                 ?>
                                <div class="modal remote fade" id="modalcreardirecciones<?= $model->idcliente ?>">
                                    <div class="modal-dialog modal-lg" style ="width: 580px;">
                                         <div class="modal-content"></div>
                                    </div>
                                </div> 
                            </div>   
                        <?php }?>
                    </div>   
                </div>
            </div>
            <!--TERMINA TABS DIRECCIONES--->
        </div>
    </div> 
    <?php ActiveForm::end(); ?>  
</div>
