<?php

use yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Subir Archivos';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
     "method" => "post",
     "enableClientValidation" => true,
    "options" => ['enctype' => 'multipart/form-data'],
     ]); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            Información Archivo a subir
        </div>
        <div class="panel-body">
            <div class="row">
                <?= $form->field($model, 'numero')->input('hidden')?>
            </div>
            <div class="row">
                <?= $form->field($model, 'codigo')->input("hidden") ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'view')->input("hidden") ?>
            </div>
            <div class="row">
                <label id="descripcion" for="descripcion" class="col-sm-3 control-label">Descripción</label>
                <div class="col-sm-5 form-group">
                    <?= Html::textInput('descripcion', '', ['id' => 'descripcion', 'aria-required' => true, 'aria-invalid' => 'false', 'maxlength' => 120, 'class' => 'form-control', 'style' => 'width:65%', 'required' => true]) ?>                        
                </div>   
            </div>                
            <div class="row">
                <?= $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>
            </div>
            <div class="panel-footer text-right">                
                <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['archivodir/index', 'numero' => $model->numero,'codigo' => $model->codigo,'view' => $view], ['class' => 'btn btn-primary']); ?>
                <?= Html::submitButton("<span class='glyphicon glyphicon-upload'></span> Subir Archivo", ["class" => "btn btn-success",]) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>