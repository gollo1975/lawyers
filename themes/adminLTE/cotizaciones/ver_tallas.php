<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ComprobanteEgreso */

$this->title = 'LISTADO DE TALLAS';
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['view','id' => $id, 'token' => $token]];
$this->params['breadcrumbs'][] = $model->id_cotizacion;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="cotizaciones-ver_talla">

    <p>
        <div class="btn-group btn-sm" role="group">
            <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['view', 'id' => $id, 'token' => $token], ['class' => 'btn btn-primary btn-sm']);?>
        </div>    
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h5><?= Html::encode($this->title) ?></h5>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'Codigo') ?>:</th>
                    <td><?= Html::encode($model->codigo) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'Referencia') ?>:</th>
                    <td><?= Html::encode($model->referencia) ?></td>
                      <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'user_name') ?>:</th>
                    <td><?= Html::encode($model->user_name) ?></td>
                      <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'Cantidad') ?>:</th>
                    <td align="right"><?= Html::encode(''.number_format($model->cantidad_referencia,0)) ?></td>
                   
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
   
    <!--INICIOS DE TABS-->
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#listadotallas" aria-controls="listadotallas" role="tab" data-toggle="tab">Listado de tallas <span class="badge"><?= count($tallas_referencia) ?></span></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="listadotallas">
                <div class="table-responsive">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style="font-size: 90%;">
                                        <th scope="col" style='background-color:#caf0f8;'>TALLA</th>
                                        <th scope="col" style='background-color:#caf0f8;'>REFERENCIA</th>
                                        <th scope="col" style='background-color:#caf0f8;'>NUMERO COTIZACION</th>
                                        <th scope="col" style='background-color:#caf0f8;'>CANTIDAD</th>
                                        <th scope="col" style='background-color:#caf0f8;'>USER NAME</th>
                                        <th scope="col" style='background-color:#caf0f8;'></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tallas_referencia as $val):?>
                                       <tr style="font-size: 90%;">
                                            <td><?= $val->talla->nombre_talla ?></td>
                                            <td><?= $val->detalleCotizacion->referencia ?></td>
                                            <td><?= $val->cotizacion->numero_cotizacion ?></td>
                                            <td style="text-align: right;"><input type="text" name="cantidad[]" style="text-align: right" value="<?= $val->cantidad ?>" required></td>
                                            <td><?= $model->user_name ?></td>
                                            <input type="hidden" name="listado_tallas[]" value="<?= $val->codigo_talla ?>">
                                           <td style= 'width: 25px; height: 25px;'>
                                               <?php 
                                                if($model->cotizacion->autorizado == 0){
                                                    echo Html::a('', ['eliminar_lineas', 'id_talla' => $val->codigo_talla, 'id' => $id, 'id_referencia' =>$id_referencia, 'token' => $token], [
                                                        'class' => 'glyphicon glyphicon-trash',
                                                        'data' => [
                                                            'confirm' => 'Esta seguro de eliminar el registro?',
                                                            'method' => 'post',
                                                        ],
                                                    ]);
                                                }?>
                                            </td>
                                       </tr>  
                                    <?php endforeach;?>   
                                </<body>
                            </table>
                        </div>
                        <div class="panel-footer text-right"> 
                            <?php 
                            if($model->cotizacion->autorizado == 0){
                                echo Html::submitButton("<span class='glyphicon glyphicon-refresh'></span> Actualizar", ["class" => "btn btn-warning btn-sm", 'name' => 'actualizar_cantidades']);
                            }else{
                                echo  Html::a('<span class="glyphicon glyphicon-export"></span> Expotar excel', ['excel_tallas', 'id' => $model->id_cotizacion, 'id_referencia'=>$id_referencia], ['class' => 'btn btn-primary btn-sm']);
                            } ?>
                        </div>     
                    </div>    
                </div>
            </div> 
            <!--TERMINA TABS DE OPERACIONES-->
        </div>
    </div>
     <?php ActiveForm::end(); ?>
</div>

