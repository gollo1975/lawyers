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
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'nota_comercial') ?></th>
                    <td colspan="6"><?= Html::encode($model->nota_comercial) ?></td>                    
                </tr>   
                 <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'descripcion') ?></th>
                    <td colspan="6"><?= Html::encode($model->descripcion) ?></td>                    
                </tr> 
                <tr style="font-size: 90%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'nota_interna') ?></th>
                    <td colspan="6"><?= Html::encode($model->nota_interna) ?></td>                    
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
             <li role="presentation" class="active"><a href="#simuladorcosto"aria-controls="simuladorcosto" role="tab" data-toggle="tab">Simulador de costo <span class="badge"><?= count($simulador) ?></span></a></li>
            <li role="presentation"><a href="#listaprecio"aria-controls="listaprecio" role="tab" data-toggle="tab">Lista de precios <span class="badge"><?= count($lista_precio) ?></span></a></li>
            <li role="presentation"><a href="#imagenes"aria-controls="imagenes" role="tab" data-toggle="tab">Imagenes <span class="badge"><?= count($imagenes) ?></span></a></li>
            
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="simuladorcosto">
                <div class="table-responsive">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="panel panel-primary">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr style="font-size: 85%;">
                                            <th scope="col" style='background-color:#caf0f8;'>CODIGO INSUMO</th>
                                            <th scope="col" style='background-color:#caf0f8;'>INSUMO</th>
                                            <th scope="col" style='background-color:#caf0f8;'>VLR UNITARIO</th>
                                            <th scope="col" style='background-color:#caf0f8;'>CANTIDAD</th>
                                             <th scope="col" style='background-color:#caf0f8;'>TOTAL COSTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($simulador as $lista):?>
                                            <tr style="font-size: 90%;">
                                                <td><?= $lista->insumo->codigo_insumo?></td>
                                                <td><?= $lista->insumo->nombre_insumo?></td>
                                                <td style="padding-right: 1;padding-right: 0; text-align: right"> <input type="text" name="valor_costo[]" value="<?= $lista->valor_costo ?>" style="text-align: right" size="9" required="true"> </td> 
                                                <td style="padding-right: 1;padding-right: 0; text-align: right"> <input type="text" name="cantidad[]" value="<?= $lista->cantidad ?>" style="text-align: right" size="9" required="true"> </td>     
                                                <td style="text-align: right" ><?= '$'. number_format($lista->total_linea,0)?></td>
                                                <input type="hidden" name="listado_insumos[]" value="<?= $lista->id_simulador ?>">
                                                 
                                            </tr>
                                        <?php
                                        endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer text-right" > 
                                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Agregar insumos', ['referencia-producto/buscar_insumos', 'id' => $model->codigo],[ 'class' => 'btn btn-warning btn-sm']) ?>
                                <?php if(count($simulador)> 0){?>
                                     <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Actualizar", ["class" => "btn btn-primary btn-sm", 'name' => 'actualizar_lineas_insumos']);?>    
                                <?php }?> 
                            </div>    
                        </div>
                    </div>   
                </div>
            </div>
            <!--TERMINA TABS-->
            <div role="tabpanel" class="tab-pane" id="listaprecio">
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
                                            <th scope="col" style='background-color:#caf0f8; width: 40%'>NOTA</th>
                                            <th scope="col" style='background-color:#caf0f8;'></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($lista_precio as $lista):?>
                                            <tr style="font-size: 90%;">
                                                <td><?= $lista->id_detalle?></td>
                                                <td style="padding-right: 1;padding-right: 0; text-align: right"> <input type="text" name="precio_venta_publico[]" value="<?= $lista->valor_venta ?>" style="text-align: right" size="7" required="true"> </td> 
                                                <td style="padding-left: 1;padding-right: 0;"><?= Html::dropDownList('lista_precio[]', $lista->id_lista, $listaPrecio, ['class' => 'col-sm-8', 'prompt' => 'Seleccione', 'required' => true]) ?></td>
                                                <td><?= $lista->user_name?></td>
                                                 <td><?= $lista->nota?></td>
                                                <td style="width: 25px; height: 25px;">
                                                       <!-- Inicio Nuevo Detalle proceso -->
                                                         <?= Html::a('<span class="glyphicon glyphicon-list"></span> ',
                                                             ['/referencia-producto/subir_nota', 'id' => $model->codigo, 'id_referencia' => $lista->id_detalle],
                                                             [
                                                                 'title' => 'Permite crear las observaciones al precio de venta.',
                                                                 'data-toggle'=>'modal',
                                                                 'data-target'=>'#modalsubirnota'.$lista->id_detalle,
                                                             ])    
                                                        ?>
                                                       <div class="modal remote fade" id="modalsubirnota<?= $lista->id_detalle ?>">
                                                         <div class="modal-dialog modal-lg" style ="width: 550px;">
                                                             <div class="modal-content"></div>
                                                         </div>
                                                       </div>
                                                   </td>
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
            <!--TEMINA TABS DE PRECIOS-->
            <div role="tabpanel" class="tab-pane" id="imagenes">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <div class="jumbotron">
                                <div class="container">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div id="carousel-example-captions" class="carousel slide" data-ride="carousel"> 
                                            <ol class="carousel-indicators">
                                                <?php for ($i=0; $i<count($imagenes); $i++):
                                                    $active = "active";?>
					            <li data-target="#carousel-example-captions" data-slide-to="<?php echo $i;?>" class="<?php echo $active;?>"></li>
					            <?php
						    $active = "";
                                                endfor;?>
                                            </ol>
                                            <div class="carousel-inner" role="listbox"> 
                                                <?php
                                                $active="active";
                                                foreach ($imagenes as $dato){
                                                   $cadena = 'Documentos/' . $dato->numero . '/' . $dato->codigo . '/' . $dato->nombre;
                                                   if($dato->extension == 'png' || $dato->extension == 'jpeg' || $dato->extension == 'jpg'){  ?>
                                                    <div class="item <?php echo $active;?>"> 
                                                        <img style="width: 100%; height: 100%" src="<?= $cadena;?>" data-holder-rendered = "true"> 
                                                            <div class="carousel-caption"> 
                                                               <p><?= $dato->descripcion;?></p>
                                                            </div> 
                                                    </div>
                                                    <?php
                                                    $active="";
                                                   } 
                                                } ?>
                                            </div> 
                                            <a class="left carousel-control" href="#carousel-example-captions" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> 
                                            <a class="right carousel-control" href="#carousel-example-captions" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> 
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>        
                    </div>   
                </div>
            </div>
            <!--TERMINA TABS-->
        </div>    
    </div>  
      <?php ActiveForm::end(); ?>
</div>


