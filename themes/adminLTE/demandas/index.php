<?php


//clases
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\data\Pagination;
use kartik\depdrop\DepDrop;
//Modelos...
use app\models\Cliente;
use app\models\Juzgados;
use app\models\ClasesDemandas;
use app\models\Especialidades;
use app\models\Abogados;
use app\models\Demandados;

$this->title = 'Procesos';
$this->params['breadcrumbs'][] = $this->title;

?>
<script language="JavaScript">
    function mostrarfiltro() {
        divC = document.getElementById("filtro");
        if (divC.style.display == "none"){divC.style.display = "block";}else{divC.style.display = "none";}
    }
</script>

<!--<h1>Lista Facturas</h1>-->
<?php $formulario = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("demandas/index"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);

$cliente = ArrayHelper::map(Cliente::find()->orderBy('nombrecorto ASC')->all(), 'idcliente', 'nombrecorto');
$juzgado = ArrayHelper::map(Juzgados::find()->orderBy('nombre_juzgado ASC')->all(), 'codigo_juzgado', 'nombre_juzgado');
$claseDemanda = ArrayHelper::map(ClasesDemandas::find()->orderBy('concepto ASC')->all(), 'id_clase_demanda', 'concepto');
$especialidad = ArrayHelper::map(Especialidades::find()->orderBy('especialidad ASC')->all(), 'id_especialidad', 'especialidad');
$abogado = ArrayHelper::map(Abogados::find()->orderBy('nombre_completo ASC')->all(), 'documento', 'nombre_completo');
$demandado = ArrayHelper::map(Demandados::find()->orderBy('nombre_completo ASC')->all(), 'documento', 'nombre_completo');

?>
<div class="panel panel-success panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtro" style="display:none">
        <div class="row" >
            <?= $formulario->field($form, "nro_demanda")->input("search") ?>
            <?= $formulario->field($form, 'idcliente')->widget(Select2::classname(), [
               'data' => $cliente,
               'options' => ['prompt' => 'Seleccione...'],
               'pluginOptions' => [
                   'allowClear' => true
               ],
            ]); ?>
             <?= $formulario->field($form, 'desde')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Seleccione una fecha ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-m-d',
                        'todayHighlight' => true]])
                ?>
                <?= $formulario->field($form, 'hasta')->widget(DatePicker::className(), ['name' => 'check_issue_date',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Seleccione una fecha ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-m-d',
                        'todayHighlight' => true]])
                ?>   
             <?= $formulario->field($form, 'codigo_juzgado')->widget(Select2::classname(), [
                   'data' => $juzgado,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
            <?= $formulario->field($form, 'id_clase_demanda')->widget(Select2::classname(), [
                   'data' => $claseDemanda,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
            <?= $formulario->field($form, 'id_especialidad')->widget(Select2::classname(), [
                   'data' => $especialidad,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
            <?= $formulario->field($form, 'documento')->widget(Select2::classname(), [
                   'data' => $abogado,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
            <?= $formulario->field($form, 'documento_demandado')->widget(Select2::classname(), [
                   'data' => $demandado,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
               
               </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute("demandas/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
        </div>
    </div>
</div>

<?php $formulario->end() ?>
<?php
$form = ActiveForm::begin([
                "method" => "post",                            
            ]);
    ?>
<div class="table-responsive">
<div class="panel panel-success ">
    <div class="panel-heading">
          Registros: <span class="badge"><?= $pagination->totalCount ?></span>
    </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style ='font-size: 85%;'>         
                <th scope="col" style='background-color:#B9D5CE;'>No</th>
                <th scope="col" style='background-color:#B9D5CE;'>No radicado</th>
                <th scope="col" style='background-color:#B9D5CE;'>Demandante</th>
                <th scope="col" style='background-color:#B9D5CE;'>Proceso</th>
                <th scope="col" style='background-color:#B9D5CE;'>Especialidad</th>
                <th scope="col" style='background-color:#B9D5CE;'>Juzgado</th>
                <th scope="col" style='background-color:#B9D5CE;'>Fecha radicado</th>
                <th scope="col" style='background-color:#B9D5CE;'></th>
                <th scope="col" style='background-color:#B9D5CE;'></th>
                                           
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $val):?>
            <tr style ='font-size: 85%;'>                
                <td><?= $val->nro_demanda ?></td>
                 <td><?= $val->radicado ?></td>
                 <td><?= $val->cliente->nombrecorto ?></td>
                <td><?= $val->claseDemanda->concepto ?></td>
                  <td><?= $val->especialidad->especialidad ?></td>
                <td><?= $val->codigoJuzgado->nombre_juzgado ?></td>
                <td><?= $val->fecha_presentacion ?></td>
                <td style= 'width: 23px; height: 23px;'>
                <a href="<?= Url::toRoute(["demandas/view", "id" => $val->nro_demanda]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
                <td style= 'width: 23px; height: 23px;'>
                    <a href="<?= Url::toRoute(["demandas/update", "id" => $val->nro_demanda]) ?>" ><span class="glyphicon glyphicon-pencil"></span></a>                   
                </td>
            </tr>            
            <?php endforeach; ?>
            </tbody>    
        </table> 
        <div class="panel-footer text-right" >            
           <?= Html::submitButton("<span class='glyphicon glyphicon-export'></span> Excel", ['name' => 'excel','class' => 'btn btn-primary btn-sm']); ?>                
           <a align="right" href="<?= Url::toRoute("demandas/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Crear demanda</a> 
           <?php $form->end() ?>
        </div>
     </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>

