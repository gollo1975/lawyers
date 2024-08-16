<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Municipio */

$this->title = 'REFERENCIAS';
$this->params['breadcrumbs'][] = ['label' => 'Referencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->codigo;
$listaPrecio = ArrayHelper::map(\app\models\ListaPrecios::find()->orderBy('id_lista ASC')->all(), 'id_lista', 'nombre_lista');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="referencia-producto-view">

   <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->codigo], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            Registros...
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'codigo') ?></th>
                    <td>R-<?= Html::encode($model->codigo) ?></td>                    
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'descripcion_referencia') ?></th>
                    <td><?= Html::encode($model->descripcion_referencia) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'id_grupo') ?></th>
                    <td><?= Html::encode($model->grupo->concepto) ?></td>                    
                </tr>
                <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'F._registro') ?></th>
                    <td><?= Html::encode($model->fecha_registro) ?></td>                    
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'user_name') ?></th>
                    <td><?= Html::encode($model->user_name) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'costo_producto') ?></th>
                    <td style="text-align: right"><?= Html::encode(''. number_format($model->costo_producto,0)) ?></td>                    
                </tr>    
                 <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'descripcion') ?></th>
                    <td colspan="6"><?= Html::encode($model->descripcion) ?></td>                    
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
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#listaprecio"aria-controls="listaprecio" role="tab" data-toggle="tab">Lista de precios <span class="badge"><?= count($lista_precio) ?></span></a></li>
            
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="listaprecion">
                <div class="table-responsive">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="panel panel-primary">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr style="font-size: 85%;">
                                            <th scope="col" style='background-color:#caf0f8;'>ID</th>
                                            <th scope="col" style='background-color:#caf0f8;'>VLR VENTA</th>
                                            <th scope="col" style='background-color:#caf0f8;'>LISTA PRECIOS</th>
                                            <th scope="col" style='background-color:#caf0f8;'>USER NAME</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($lista_precio as $lista):?>
                                            <tr style="font-size: 90%;">
                                                <td><?= $lista->id_detalle?></td>
                                                <td style="padding-right: 1;padding-right: 0; text-align: right"> <input type="text" name="precio_venta_publico[]" value="<?= $lista->valor_venta ?>" style="text-align: right" size="9" required="true"> </td> 
                                                <td style="padding-left: 1;padding-right: 0;"><?= Html::dropDownList('lista_precio[]', $lista->id_lista, $listaPrecio, ['class' => 'col-sm-10', 'prompt' => 'Seleccione', 'required' => true]) ?></td>
                                                <td><?= $lista->user_name?></td>
                                                <input type="hidden" name="listado_precios[]" value="<?= $lista->id_detalle ?>">
                                                 
                                            </tr>
                                        <?php
                                        endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer text-right" >  
                                <!-- Inicio Nuevo Detalle proceso -->
                                  <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear precio',
                                      ['/referencia-producto/nuevo_precio_venta','id' => $model->codigo],
                                      [
                                          'title' => 'Crear nuevo precio de venta',
                                          'data-toggle'=>'modal',
                                          'data-target'=>'#modalnuevoprecioventa'.$model->codigo,
                                          'class' => 'btn btn-info btn-sm'
                                      ])    
                                 ?>
                                <div class="modal remote fade" id="modalnuevoprecioventa<?= $model->codigo ?>">
                                    <div class="modal-dialog modal-lg" style ="width: 500px;">
                                         <div class="modal-content"></div>
                                    </div>
                                </div> 
                                <?php if(count($lista_precio)> 0){?>
                                     <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Actualizar", ["class" => "btn btn-warning btn-sm", 'name' => 'actualizar_precio_venta']);?>    
                                <?php }?> 
                            </div>
                        </div>   
                        </div>
                    </div>
                </div>    
                <!--TERMINA TABS-->
    </div>  
      <?php ActiveForm::end(); ?>
</div>


