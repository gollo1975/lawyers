<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Municipio;
use app\models\Departamento;
use app\models\TipoDocumento;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
?>

<?php

$this->title = 'Detalle del cliente';
$this->params['breadcrumbs'][] = ['label' => 'Consulta Clientes', 'url' => ['index_consulta']];
$this->params['breadcrumbs'][] = $this->title;
$view = 'clientes';
?>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index_consulta'], ['class' => 'btn btn-primary btn-sm']) ?>    
</p>

<div class="panel panel-success">
    <div class="panel-heading">
        Información
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
           <tr style="font-size: 85%;">
                <th style='background-color:#F0F3EF;'>Código:</th>
                <td><?= $table->idcliente ?></td>
                <th style='background-color:#F0F3EF;'>Tipo Identificación:</th>
                <td><?= $table->tipo->tipo ?></td>
                <th style='background-color:#F0F3EF;'>Cedula/Nit:</th>
                <td><?= $table->cedulanit ?></td>
                <th style='background-color:#F0F3EF;'>DV:</th>
                <td><?= $table->dv ?></td>
            </tr>
            <tr style="font-size: 85%;">
                <?php if ($table->id_tipo_documento == 1){ ?>
                <th style='background-color:#F0F3EF;'>Nombres:</th>
                <td><?= $table->nombrecliente ?></td>
                <th style='background-color:#F0F3EF;'>Apellidos:</th>
                <td><?= $table->apellidocliente ?></td>
                <?php } elseif ($table->id_tipo_documento == 5) { ?>
                <th style='background-color:#F0F3EF;'>Razon Social:</th>
                <td><?= $table->razonsocial ?></td>
                <th style='background-color:#F0F3EF;'></th>
                <td></td>
                <?php } else { ?>
                <th style='background-color:#F0F3EF;'>Nombres:</th>
                <td><?= $table->nombrecliente ?></td>
                <th style='background-color:#F0F3EF;'>Apellidos:</th>
                <td><?= $table->apellidocliente ?></td>    
                <?php }?>
                <th style='background-color:#F0F3EF;'>Email:</th>
                <td><?= $table->emailcliente ?></td>
                <th style='background-color:#F0F3EF;' >Dirección:</th>
                <td><?= $table->direccioncliente ?></td>
            </tr>
            <tr style="font-size: 85%;">
                <th style='background-color:#F0F3EF;'>Teléfono:</th>
                <td><?= $table->telefonocliente ?></td>
                <th style='background-color:#F0F3EF;'>Celular:</th>
                <td><?= $table->celularcliente ?></td>
                <th style='background-color:#F0F3EF;'>Departamento:</th>
                <td><?= $table->departamento->departamento ?></td>
                <th style='background-color:#F0F3EF;' >Municipio:</th>
                <td><?= $table->municipio->municipio ?></td>
            </tr>
            <tr style="font-size: 85%;">
                <th style='background-color:#F0F3EF;'>Contacto:</th>
                <td><?= $table->contacto ?></td>
                <th style='background-color:#F0F3EF;'>Celular:</th>
                <td ><?= $table->celularcontacto ?></td>
                <th style='background-color:#F0F3EF;'>Forma de Pago:</th>
                <td><?php if ($table->formapago = 1){echo "Contado";} else {echo "Crédito";}  ?></td>
                <th style='background-color:#F0F3EF;'>Plazo:</th>
                <td><?= $table->plazopago ?></td>
            </tr>
            <tr style="font-size: 85%;">
                 <th style='background-color:#F0F3EF;'>Tipo Regimen:</th>
                <td><?= $table->regimen ?></td>
                <th style='background-color:#F0F3EF;'>AutoRetenedor:</th>
                <td><?= $table->autoretener ?></td>
                <th style='background-color:#F0F3EF;'>Retención Fuente:</th>
                <td><?= $table->retenerfuente ?></td>
                <th style='background-color:#F0F3EF;'>Retención Iva:</th>
                <td><?= $table->reteneriva ?></td>
            </tr>
            <tr style="font-size: 85%;">
                 <th style='background-color:#F0F3EF;'>Observaciones:</th>
                 <td colspan="7"><?= $table->observacion ?></td>
            </tr>
            
        </table>
    </div>
     <!-- INICIO DEL TABS-->
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#facturas" aria-controls="facturas" role="tab" data-toggle="tab">Facturas <span class="badge"><?= count($facturas) ?></span></a></li>
            <li role="presentation"><a href="#procesos" aria-controls="procesos" role="tab" data-toggle="tab">Procesos <span class="badge"><?= count($proceso) ?></span></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="facturas">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style="font-size: 85%;">
                                        <th scope="col" style='background-color:#B9D5CE;'>No factura</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Proceso</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Fecha inicio</th>
                                          <th scope="col" style='background-color:#B9D5CE;'>Fecha vencimiento</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Total pagar</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Saldo</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Usuario</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Observación</th>
                                    </tr>    
                                </thead>
                                <tbody>
                                     <?php foreach ($facturas as $val):?>
                                        <tr style ='font-size: 85%;'>                
                                            <td><?= $val->nro_factura ?></td>
                                            <td><?= $val->demanda->claseDemanda->concepto ?></td>
                                             <td><?= $val->fecha_inicio ?></td>
                                              <td><?= $val->fecha_vencimiento ?></td>
                                            <td style="text-align: right"><?= ''.number_format($val->totalpagar, 0) ?></td>
                                            <td style="text-align: right"><?= ''.number_format($val->saldo, 0) ?></td>
                                            <td><?= $val->usuariosistema ?></td>
                                            <td><?= $val->observacion ?></td>
                                        </tr>    
                                    <?php endforeach;?>
                                </tbody>   
                            </table>    
                        </div>
                    </div>
                </div>
            </div>
            <!--TERMINA TABS DE FACTURACION-->
            <div role="tabpanel" class="tab-pane" id="procesos">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style="font-size: 85%;">
                                        <th scope="col" style='background-color:#B9D5CE;'>Id</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Radicado</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Proceso</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Especialidad</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Fecha radicado</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Demandado</th>
                                        <th scope="col" style='background-color:#B9D5CE;'>Juzgado</th>
                                    </tr>    
                                </thead>
                                <tbody>
                                     <?php foreach ($proceso as $val):?>
                                        <tr style ='font-size: 85%;'>                
                                            <td><?= $val->nro_demanda ?></td>
                                             <td><?= $val->radicado ?></td>
                                            <td><?= $val->claseDemanda->concepto ?></td>
                                            <td><?= $val->especialidad->especialidad ?></td>
                                            <td><?= $val->fecha_presentacion ?></td>
                                             <td><?= $val->documentoDemandado->nombre_completo ?></td>
                                            <td><?= $val->codigoJuzgado->nombre_juzgado ?></td>
                                          
                                        </tr>            
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- TERMINA TABS DE PROCESOS-->
        </div>    
    </div>    
     <!-- TERMINA LOS TABS-->
</div>

