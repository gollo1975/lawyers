<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ComprobanteEgreso */

$this->title = 'COTIZACIONES';
$this->params['breadcrumbs'][] = ['label' => 'Cotizacion del cliente', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id_cotizacion;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="cotizaciones-view">

    <p>
        <div class="btn-group btn-sm" role="group">
            <?php if($token == 0){
                echo Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']);
            }else{
                echo Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index_cotizaciones'], ['class' => 'btn btn-primary btn-sm']);
            }
            if($token == 0){
                if ($model->autorizado == 0 && $model->numero_cotizacion == 0) { 
                    echo Html::a('<span class="glyphicon glyphicon-ok"></span> Autorizar', ['autorizado', 'id' => $model->id_cotizacion, 'token' => $token], ['class' => 'btn btn-default btn-sm']); }
                else {
                    if ($model->autorizado == 1 && $model->numero_cotizacion == 0 ) {
                        echo Html::a('<span class="glyphicon glyphicon-remove"></span> Desautorizar', ['autorizado', 'id' => $model->id_cotizacion, 'token' => $token], ['class' => 'btn btn-default btn-sm']);
                        echo Html::a('<span class="glyphicon glyphicon-remove"></span> Cerrar cotización', ['cerrar_pedido', 'id' => $model->id_cotizacion,'token' => $token],['class' => 'btn btn-info btn-sm',
                             'data' => ['confirm' => 'Esta seguro que desea cerrar la cotizacion del cliente ('.$model->cliente->nombrecorto.')', 'method' => 'post']]);
                    }else{    
                         echo Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir cotización', ['/cotizaciones/imprimir_pedido', 'id' => $model->id_cotizacion],['class' => 'btn btn-default btn-sm']);
                         echo Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir tallas', ['/cotizaciones/imprimir_tallas', 'id' => $model->id_cotizacion],['class' => 'btn btn-default btn-sm']);
                    }    
                }
            }else{
                if($model->numero_cotizacion > 0){
                   echo Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir cotización', ['/cotizaciones/imprimir_pedido', 'id' => $model->id_cotizacion],['class' => 'btn btn-default btn-sm']);
                         echo Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir tallas', ['/cotizaciones/imprimir_tallas', 'id' => $model->id_cotizacion],['class' => 'btn btn-default btn-sm']); 
                }
            }?>
        </div>    
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h5><?= Html::encode($this->title) ?></h5>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                <tr style="font-size: 85%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'Id') ?>:</th>
                    <td><?= Html::encode($model->id_cotizacion) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'numero_cotizacion') ?></th>
                    <td><?= Html::encode($model->numero_cotizacion) ?></td>
                      <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'id_cliente') ?></th>
                    <td><?= Html::encode($model->cliente->nombrecorto) ?></td>
                      <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'subtotal') ?>:</th>
                    <td align="right"><?= Html::encode(''.number_format($model->subtotal,0)) ?></td>
                   
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'fecha_cotizacion') ?>:</th>
                    <td><?= Html::encode($model->fecha_cotizacion) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'fecha_entrega') ?>:</th>
                    <td><?= Html::encode($model->fecha_entrega) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'fecha_registro') ?>:</th>
                    <td ><?= Html::encode($model->fecha_registro) ?>%</td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'impuesto') ?>:</th>
                    <td align="right"><?= Html::encode(''.number_format($model->impuesto,0)) ?></td>
                  
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'total_prendas') ?>:</th>
                    <td style="text-align: right"><?= Html::encode(''.number_format($model->total_prendas,0)) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'user_name') ?>:</th>
                    <td><?= Html::encode($model->user_name) ?></td>
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'proceso_cerrado') ?>:</th>
                    <td align="right"><?= Html::encode($model->procesoCerrado) ?></td>
                     <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'total_cotizacion') ?>:</th>
                    <td align="right"><?= Html::encode(''.number_format($model->total_cotizacion,0)) ?></td>
                </tr>
                <tr style="font-size: 85%;">
                    <th style='background-color:#edf2f4;'><?= Html::activeLabel($model, 'observacion') ?>:</th>
                    <td colspan="7"><?= Html::encode($model->observacion) ?></td>
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
            <li role="presentation" class="active"><a href="#listadoreferencias" aria-controls="listadoreferencias" role="tab" data-toggle="tab">Referencias <span class="badge"><?= count($referencias) ?></span></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="listadoreferencias">
                <div class="table-responsive">
                    <div class="panel panel-success">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style="font-size: 90%;">
                                        <th scope="col" style='background-color:#caf0f8;'>CODIGO</th>
                                        <th scope="col" style='background-color:#caf0f8;'>REFERENCIA</th>
                                        <th scope="col" style='background-color:#caf0f8;'>IMAGEN</th>
                                        <th scope="col" style='background-color:#caf0f8;'>COSTO</th>
                                        <th scope="col" style='background-color:#caf0f8;'>LISTA</th>
                                        <th scope="col" style='background-color:#caf0f8;'>VR. VENTA</th>
                                        <th scope="col" style='background-color:#caf0f8;'>CANT.</th>
                                        <th scope="col" style='background-color:#caf0f8;'>SUBTOTAL</th>
                                        <th scope="col" style='background-color:#caf0f8;'>IVA</th>
                                        <th scope="col" style='background-color:#caf0f8;'>TOTAL</th>
                                         <th scope="col" style='background-color:#caf0f8;'></th>
                                         <th scope="col" style='background-color:#caf0f8;'></th>
                                         <th scope="col" style='background-color:#caf0f8;'></th>
                                        <th scope="col" style='background-color:#caf0f8;'><input type="checkbox" onclick="marcar(this);"/></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cadena = '';
                                    $item = \app\models\Documentodir::findOne(1);
                                    foreach ($referencias as $val): 
                                        //permite buscar la imgane
                                        $valor = app\models\DirectorioArchivos::find()->where(['=','codigo', $val->codigo])
                                                                  ->andWhere(['=','predeterminado', 1])->andWhere(['=','numero', $item->codigodocumento])->one();
                                        $conLista = app\models\ReferenciaListaPrecio::find()->where(['=','codigo', $val->codigo])->all();
                                        $conLista = ArrayHelper::map($conLista, 'id_detalle', 'verLista');
                                        ?>
                                       <tr style="font-size: 90%;">
                                            <td>R-<?= $val->codigo ?></td>
                                            <td><?= $val->referencia ?></td>
                                            <?php if($valor){
                                                $cadena = 'Documentos/'.$valor->numero.'/'.$valor->codigo.'/'. $valor->nombre;
                                                if($valor->extension == 'png' || $valor->extension == 'jpeg' || $valor->extension == 'jpg'){?>
                                                   <td  style=" text-align: center; background-color: white" title="<?php echo $val->codigoReferencia->descripcion_referencia ?>"> <?= yii\bootstrap\Html::img($cadena, ['width' => '80;', 'height' => '60;'])?></td>
                                                <?php }else {?>
                                                    <td><?= 'NOT FOUND'?></td>
                                                <?php } 
                                            }else{?>
                                                  <td></td>
                                            <?php }?>      
                                            <td style="text-align: right" ><?= ''. number_format($val->codigoReferencia->costo_producto,0) ?></td>
                                            <td style="padding-left: 1;padding-right: 0;"><?= Html::dropDownList('tipo_lista[]', $val->id_detalle, $conLista, ['class' => 'col-sm-8', 'prompt' => 'Seleccione', 'required' => true]) ?></td>
                                            <td style="text-align: right"><?= '$'. number_format($val->valor_unidad,0)?></td>
                                            <td style="text-align: right"><?= ''. number_format($val->cantidad_referencia,0)?></td>
                                            <td style="text-align: right"><?= '$'. number_format($val->subtotal,0)?></td>
                                            <td style="text-align: right"><?= '$'. number_format($val->impuesto,0)?></td>
                                            <td style="text-align: right"><?= '$'. number_format($val->total_linea,0)?></td>
                                            <?php if ($model->autorizado == 0){
                                                if($val->valor_unidad > 0){
                                                    $conTalla = \app\models\CotizacionDetalleTalla::find()->where(['=','id', $val->id])->one(); 
                                                    if(!$conTalla){ ?>
                                                        <td style= 'width: 25px; height: 25px;'>
                                                            <a href="<?= Url::toRoute(["cotizaciones/crear_tallas_referencia", "id" => $model->id_cotizacion, 'id_referencia' => $val->id, 'token' => $token]) ?>" ><span class="glyphicon glyphicon-import" title="Permite crear las talla a cada referencia"></span></a>
                                                        </td>
                                                        <td style= 'width: 25px; height: 25px;'></td>
                                                        <td style= 'width: 25px; height: 25px;'></td>
                                                    <?php }else{?>
                                                        <td style= 'width: 25px; height: 25px;'>
                                                            <a href="<?= Url::toRoute(["cotizaciones/crear_tallas_referencia", "id" => $model->id_cotizacion, 'id_referencia' => $val->id, 'token' => $token]) ?>" ><span class="glyphicon glyphicon-import" title="Permite crear las talla a cada referencia"></span></a>
                                                        </td>
                                                        <td style="width: 25px; height: 25px;">
                                                            <!-- Inicio Nuevo Detalle proceso -->
                                                              <?= Html::a('<span class="glyphicon glyphicon-list"></span> ',
                                                                  ['/cotizaciones/subir_nota', 'id' => $model->id_cotizacion, 'id_referencia' => $val->id, 'token' => $token],
                                                                  [
                                                                      'title' => 'Permite crear las observaciones de la talla.',
                                                                      'data-toggle'=>'modal',
                                                                      'data-target'=>'#modalsubirnota'.$val->id,
                                                                  ])    
                                                             ?>
                                                            <div class="modal remote fade" id="modalsubirnota<?= $val->id ?>">
                                                              <div class="modal-dialog modal-lg" style ="width: 550px;">
                                                                  <div class="modal-content"></div>
                                                              </div>
                                                            </div>
                                                        </td>
                                                        <td style= 'width: 25px; height: 25px;'>
                                                            <a href="<?= Url::toRoute(["cotizaciones/ver_tallas", "id" => $model->id_cotizacion, 'id_referencia' => $val->id, 'token' => $token]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                                                        </td>
                                                        
                                                    <?php }    
                                                }else{?>
                                                    <td style= 'width: 25px; height: 25px;'></td>
                                                    <td style= 'width: 25px; height: 25px;'></td>
                                                    <td style= 'width: 25px; height: 25px;'></td>
                                                <?php }    
                                            }else{?>
                                                    <td style= 'width: 25px; height: 25px;'></td>
                                                    <td style= 'width: 25px; height: 25px;'></td>
                                                     <td style= 'width: 25px; height: 25px;'>
                                                                 <a href="<?= Url::toRoute(["cotizaciones/ver_tallas", "id" => $model->id_cotizacion, 'id_referencia' => $val->id, 'token' => $token]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                                                        </td>
                                                    
                                            <?php }?>        
                                            <input type="hidden" name="listado_referencia[]" value="<?= $val->id ?>">
                                            <td style="width: 30px;"><input type="checkbox" name="listado_eliminar[]" value="<?= $val->id ?>"></td>
                                           
                                       </tr>  
                                    <?php endforeach;?>   
                                </<body>
                            </table>
                        </div>
                        <div class="panel-footer text-right"> 
                            <?php 
                            if($model->autorizado == 0){
                                if(count($referencias) == 0){?>

                                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nueva Referencias', ['cotizaciones/cargar_nueva_referencia', 'id' => $model->id_cotizacion, 'token' => $token], ['class' => 'btn btn-success btn-sm']) ?>
                                <?php }else{?>
                                    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nueva Referencias', ['cotizaciones/cargar_nueva_referencia', 'id' => $model->id_cotizacion, 'token' => $token], ['class' => 'btn btn-success btn-sm']) ?>
                                    <?= Html::submitButton("<span class='glyphicon glyphicon-refresh'></span> Actualizar", ["class" => "btn btn-primary btn-sm", 'name' => 'actualizar_linea']) ?>
                                    <?= Html::submitButton("<span class='glyphicon glyphicon-trash'></span> Eliminar", ["class" => "btn btn-danger btn-sm", 'name' => 'eliminar_referencia']) ?>
                                <?php }
                            }?>
                        </div>     
                    </div>    
                </div>
            </div> 
            <!--TERMINA TABS DE OPERACIONES-->
        </div>
    </div>
     <?php ActiveForm::end(); ?>
</div>
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
