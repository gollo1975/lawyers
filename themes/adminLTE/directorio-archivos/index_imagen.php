<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;

$this->title = 'LISTADO DE IMAGENES';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="table-responsive">
<div class="panel panel-primary ">
    <div class="panel-heading">
        Registros <span class="badge"> <?= $pagination->totalCount ?></span>
    </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>                
                <th scope="col">ID</th>
                <th scope="col">FECHA CREACION</th>
                <th scope="col">IMAGEN</th>
                <th scope="col">DESCRIPCION</th>
                <th scope="col">RUTA</th>
                <th scope="col">TAMAÑO</th>
                <th scope="col">EXTENSION</th>
                <th scope="col">PRED.</th>
                <th scope="col" colspan="3">Acción</th>                               
                
            </tr>
            </thead>
            <tbody>
            <?php $variable = '';
            foreach ($model as $val): 
                 $variable = 'Documentos/'.$val->numero.'/'.$val->codigo.'/'. $val->nombre;
                ?>
                <tr style="font-size: 85%;">                
                <td><?= $val->idarchivodir ?></td>
                <td><?= $val->fecha_creacion ?></td>
                <?php if($val->extension == 'png' || $val->extension == 'jpeg' || $val->extension == 'jpg'){?>
                    <td style="width: 100px;"> <?= yii\bootstrap\Html::img($variable, ['width' => '90px;', 'height' => '95px;'])?></td>
                <?php }else {?>
                    <td><?= $val->nombre?></td>
                <?php } ?>    
                <td><?= $val->descripcion ?></td>   
                <td><?= $val->tipo ?></td>
                <td><?= $val->tamaño ?></td>
                <td><?= $val->extension ?></td>
                <td><?= $val->imagenActiva?></td>
                <td style= 'width: 15px; height: 20px;'>
                    <a href="<?= Url::toRoute(["directorio-archivos/descargar", "id" => $val->idarchivodir, 'numero' => $numero, 'codigo' => $codigo, 'token' => $token]) ?>" ><span class="glyphicon glyphicon-download"></span></a>                                        
                </td>
                <?php if($token == 0){?>
                <td style= 'width: 20px; height: 20px;'>
                    <a href="#" data-toggle="modal" data-target="#id<?= $val->idarchivodir ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <!-- Editar modal detalle -->
                                <div class="modal fade" role="dialog" aria-hidden="true" id="id<?= $val->idarchivodir ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Editar Archivo <?= $val->idarchivodir ?></h4>
                                            </div>
                                            <?= Html::beginForm(Url::toRoute(["directorio-archivos/editar_imagen", 'token' => $token]), "POST") ?>
                                            <div class="modal-body">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <h4>Editar registro..</h4>
                                                    </div>
                                                    
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <label id="descripcion" for="descripcion" class="col-sm-2 control-label">Descripción:</label>
                                                            <div class="col-sm-8 form-group">
                                                                <?= Html::textInput('descripcion', $val->descripcion, ['id' => 'descripcion', 'aria-required' => true, 'aria-invalid' => 'false', 'maxlength' => 120, 'class' => 'form-control', 'style' => 'width:100%', 'required' => true]) ?>                        
                                                            </div> 
                                                        </div>
                                                        <div class="row">
                                                            <label id="predeterminado" for="predeterminado" class="col-sm-2 control-label">Predeterminado:</label>
                                                            <div class="col-sm-8 form-group">
                                                                  <?= Html::dropdownList('predeterminado', $val->predeterminado, ['0' => 'NO', '1' => 'SI'], ['prompt' => 'Seleccione...']) ?>
                                                            </div>
                                                        </div>                                                        
                                                        <input type="hidden" name="idarchivodir" value="<?= $val->idarchivodir ?>">
                                                        <input type="hidden" name="numero" value="<?= $numero ?>">
                                                        <input type="hidden" name="codigo" value="<?= $codigo ?>">
                                                        <input type="hidden" name="token" value="<?= $token ?>">
                                                        <input type="hidden" name="validador_imagen" value="<?= $validador_imagen ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove'></span> Cerrar</button>
                                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Guardar</button>
                                            </div>
                                            <?= Html::endForm() ?>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                </td> 
                <?php }else{?>
                    <td style= 'width: 20px; height: 20px;'>
                <?php }?>
                <td style= 'width: 20px; height: 20px;'>
                    <?php if($token == 0){?>
                      <a href="<?= Url::toRoute(["directorio-archivos/borrar_imagenes", "id" => $val->idarchivodir, 'numero' => $numero, 'codigo' => $codigo,'validador_imagen' => $validador_imagen, 'token' => $token]) ?>" ><span class="glyphicon glyphicon-remove"></span></a>
                    <?php }?>
                </td>
            </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
        <div class="panel-footer text-right" >
            <?php if($token == 0){?>
                <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', [$validador_imagen.'/validador_imagen', 'id' => $codigo, 'token' => $token], ['class' => 'btn btn-primary btn-sm']); ?>
                <?= Html::a('<span class="glyphicon glyphicon-upload"></span> Subir Archivo', ['directorio-archivos/subir_imagen','numero' => $numero, 'codigo' => $codigo,'validador_imagen' =>$validador_imagen, 'token' => $token], ['class' => 'btn btn-success btn-sm']); ?>            
            <?php }else{?>
               <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', [$validador_imagen.'/validador_imagen', 'id' => $codigo, 'token' => $token], ['class' => 'btn btn-primary btn-sm']); ?>
            <?php }?>
        </div>
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>







