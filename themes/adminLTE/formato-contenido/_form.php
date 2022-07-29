<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
// modelos
use app\models\ConfiguracionFormatoPrefijo;

?>

<?php
$form = ActiveForm::begin([
            "method" => "post",
            'id' => 'formulario',
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,
            'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
            'fieldConfig' => [
            'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
            'options' => []
        ],
        ]);
?>
<?php

   $prefijo = ArrayHelper::map(ConfiguracionFormatoPrefijo::find()->where(['=','estado_formato',1])->orderBy('formato ASC')->all(), 'id_configuracion_prefijo', 'formato');
?>
<body>
<!--<h1>Editar Cliente</h1>-->

<div class="panel panel-success">
    <div class="panel-heading">
        Información: Contenidos
    </div>
    <div class="panel-body">        														   		
        <div class="row">
            <?= $form->field($model, 'nombre_formato')->textInput(['maxlength' => true]) ?>    
            <?= $form->field($model, 'id_configuracion_prefijo')->dropDownList($prefijo, ['prompt' => 'Seleccione el prefijo']) ?>
        </div>
        <div class="row" col>
            
            <?= $form->field($model, 'contenido', ['template' => '{label}<div class="col-sm-10 form-group">{input}{error}</div>'])->textarea(['rows' => 26]) ?>
        </div>
        <div class="panel-footer text-right">                
            <a href="<?= Url::toRoute("formato-contenido/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-circle-arrow-left'></span> Regresar</a>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success btn-sm",]) ?>		
        </div>
    </div>
</div>
<div>
    <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#contrato" aria-controls="contrato" role="tab" data-toggle="tab">Contratos</a></li>
            <li role="presentation"><a href="#cartas" aria-controls="cartas" role="tab" data-toggle="tab">Cartas</a></li>
            <li role="presentation"><a href="#notificacion" aria-controls="notificacion" role="tab" data-toggle="tab">Notificaciones</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="contrato">
            <div class="table-responsive">
                    <div class="panel panel-success ">
                    <div class="panel-heading">
                        Etiquetas Contratos.
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead >
                            <tr style ='font-size:85%;'>
                                <td scope="col">#1 - Documento del trabajador</td>  
                                <td scope="col">#2 - Nombre del trabajador</td> 
                                <td scope="col">#3 - Lugar de expedición</td>
                                <td scope="col">#4 - Direccion domicilio</td>
                                <td scope="col">#5 - Barrio</td>
                                <td scope="col">#6 - Nombre del cargo</td>
                                <td scope="col">#7 - Salario en letras</td>  
                            </tr>
                            <tr style ='font-size:85%;'>

                                <td scope="col">#8 - Salario contratado</td> 
                                <td scope="col">#9 - Fecha de nacimiento</td>
                                <td scope="col">#a - Fecha inicio contrato</td>
                                <td scope="col">#b - Forma de pago</td>
                                <td scope="col">#c - Ciudad de contratación</td>
                                <td scope="col">#d - Fecha final contrato</td>  
                                <td scope="col">#e - Dias contratado</td> 
                            </tr>
                            <tr style ='font-size:85%;'>

                                <td scope="col">#w - Nombre del contrato</td>
                                <td scope="col" colspan="8">#x - Nro del contrato</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>   
            <div class="table-responsive">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Etiquetas beneficio no salarial.
                    </div>
                        <table class="table table-bordered table-hover">
                            <thead >
                                <tr style ='font-size:85%;'>
                                    <td scope="col">#1 - Documento</td>  
                                    <td scope="col">#2 - Nombre empleado</td> 
                                    <td scope="col">#3 - Fecha inicio contrato</td>
                                    <td scope="col">#4 - Valor adicion (pesos)</td>
                                    <td scope="col">#5 - Fecha aplicacion</td>
                                    <td scope="col">#6 - Salario contrato</td>
                                     <td scope="col">#7 - Salario contrato (letras)</td> 
                                </tr>
                                <tr style ='font-size:85%;'>
                                    <td scope="col">#8 - Nombre concepto</td> 
                                    <td scope="col">#9 - Valor adicion (letras)</td>
                                    <td scope="col">#a - Ciudad expedicion</td>
                                    <td scope="col">#b - Empresa</td>
                                    <td scope="col">#c - Nit empresa</td>
                                    <td colspan="4"scope="col">#d - Nro de adicion</td> 
                                </tr>
                            </thead>
                        </table>
                </div>
            </div>    
            <div class="table-responsive">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Etiquetas cambio salario.
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead >
                            <tr style ='font-size:85%;'>
                                <td scope="col">#1 - Documento</td>  
                                <td scope="col">#2 - Nombre empleado</td> 
                                <td scope="col">#3 - Fecha inicio contrato</td>
                                <td scope="col">#4 - Nuevo salario (pesos)</td>
                                <td scope="col">#5 - Fecha aplicacion</td>
                                <td scope="col">#6 - Ciudad de expedicion</td>
                                 <td scope="col">#7 - Nombre de la empresa</td> 
                            </tr>
                            <tr style ='font-size:85%;'>
                                <td scope="col">#8 - Nit empresa</td> 
                                <td scope="col">#9 - Nro cambio salario</td>
                                <td scope="col" colspan="8">#a - Representante legal</td>
                            </tr>
                       </thead>
                    </table>
                </div>    
            </div>
             <div class="table-responsive">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Etiquetas prorroga contrato.
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead >
                            <tr style ='font-size:85%;'>
                                <td scope="col">#1 - Documento</td>  
                                <td scope="col">#2 - Nombre empleado</td> 
                                <td scope="col">#3 - Ciudad de expedicion</td>
                                <td scope="col">#4 - Cargo</td>
                                <td scope="col">#5 - Nombre empresa</td>
                                <td scope="col">#6 - Nit empresa</td>
                                 <td scope="col">#7 - Nro contrato</td> 
                            </tr>
                            <tr style ='font-size:85%;'>
                                <td scope="col">#8 - Fecha finalización</td> 
                                <td scope="col">#9 - Dias renovacion</td>
                                <td scope="col" >#a - fecha creacion</td>
                                <td scope="col" colspan="4">#b - Fecha renovacion</td>
                            </tr>
                       </thead>
                </table>
                </div>
            </div>     
        </div><!-- termina los panels--> 
        <!--INICIO NUEVO PANEL-->
        <div role="tabpanel" class="tab-pane active" id="cartas">
            <div class="table-responsive">
                <div class="panel panel-success ">
                    <div class="panel-heading">
                        Etiquetas carta laboral.
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead >
                            <tr style ='font-size:85%;'>
                                <td scope="col">#1 - Documento del trabajador</td>  
                                <td scope="col">#2 - Nombre del trabajador</td> 
                                <td scope="col">#3 - Lugar de expedición</td>
                                <td scope="col">#4 - Direccion domicilio</td>
                                <td scope="col">#5 - Barrio</td>
                                <td scope="col">#6 - Nombre del cargo</td>
                                <td scope="col">#7 - Salario en letras</td>  
                            </tr>
                            <tr style ='font-size:85%;'>

                                <td scope="col">#8 - Salario contratado</td> 
                                <td scope="col">#9 - Fecha de nacimiento</td>
                                <td scope="col">#a - Fecha inicio contrato</td>
                                <td scope="col">#b - Forma de pago</td>
                                <td scope="col">#c - Ciudad de contratación</td>
                                <td scope="col">#d - Fecha final contrato</td>  
                                <td scope="col">#e - Dias contratado</td> 
                            </tr>
                            <tr style ='font-size:85%;'>

                                <td scope="col">#w - Nombre del contrato</td>
                                <td scope="col" colspan="8">#x - Nro del contrato</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>   
            
        </div>
   </div><!--termina el tab-->
</div>    
<?php ActiveForm::end(); ?>