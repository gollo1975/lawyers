 <?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
use app\models\AreaJuzgado;
use app\models\Jurisdicion;
use app\models\Circuito;
use app\models\Distrito;
use app\models\Departamento;
use app\models\Municipio;
use app\models\Juez;

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


$this->title = 'Juzgados';
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
    "action" => Url::toRoute("juzgados/index"),
    "enableClientValidation" => true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
                    'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'options' => []
                ],

]);

$departamento = ArrayHelper::map(Departamento::find()->orderBy('departamento ASC')->all(), 'iddepartamento', 'departamento');
$municipio = ArrayHelper::map(Municipio::find()->orderBy('municipio ASC')->all(), 'idmunicipio', 'municipio');
$distrito = ArrayHelper::map(Distrito::find()->orderBy('nombre_distrito ASC')->all(), 'id_distrito', 'nombre_distrito');
$circuito = ArrayHelper::map(Circuito::find()->orderBy('nombre_circuito ASC')->all(), 'id_circuito', 'nombre_circuito');
$area = ArrayHelper::map(AreaJuzgado::find()->orderBy('area ASC')->all(), 'id_area_juzgado', 'area');
$jueces = ArrayHelper::map(Juez::find()->orderBy('nombre_juez ASC')->all(), 'id_juez', 'nombre_juez');
$jurisdicion = ArrayHelper::map(Jurisdicion::find()->orderBy('jurisdiccion ASC')->all(), 'id_jurisdiccion', 'jurisdiccion');

?>
<div class="panel panel-success panel-filters">
    <div class="panel-heading" onclick="mostrarfiltro()">
        Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
    </div>
	
    <div class="panel-body" id="filtro" style="display:none">
        <div class="row" >
            <?= $formulario->field($form, "codigo")->input("search") ?>
            <?= $formulario->field($form, "nombre_juzgado")->input("search") ?>       
            <?= $formulario->field($form, 'id_departamento')->widget(Select2::classname(), [
               'data' => $departamento,
               'options' => ['prompt' => 'Seleccione...'],
               'pluginOptions' => [
                   'allowClear' => true
               ],
            ]); ?>
             <?= $formulario->field($form, 'id_municipio')->widget(Select2::classname(), [
                   'data' => $municipio,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
            <?= $formulario->field($form, 'circuito')->widget(Select2::classname(), [
                   'data' => $circuito,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
            <?= $formulario->field($form, 'distrito')->widget(Select2::classname(), [
                   'data' => $distrito,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
            <?= $formulario->field($form, 'id_area')->widget(Select2::classname(), [
                   'data' => $area,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
            <?= $formulario->field($form, 'id_juez')->widget(Select2::classname(), [
                   'data' => $jueces,
                   'options' => ['prompt' => 'Seleccione...'],
                   'pluginOptions' => [
                       'allowClear' => true
                   ],
               ]); ?>
               </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
            <a align="right" href="<?= Url::toRoute("juzgados/index") ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
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
                <th scope="col" style='background-color:#B9D5CE;'>Código</th>
                <th scope="col" style='background-color:#B9D5CE;'>Juzgado</th>
                <th scope="col" style='background-color:#B9D5CE;'>Dirección</th>
                <th scope="col" style='background-color:#B9D5CE;'>Telófono</th>
                <th scope="col" style='background-color:#B9D5CE;'>Celular</th>
                <th scope="col" style='background-color:#B9D5CE;'>Email</th>
                <th scope="col" style='background-color:#B9D5CE;'>Dpto</th>
                <th scope="col" style='background-color:#B9D5CE;'>Municipio</th>
                <th scope="col" style='background-color:#B9D5CE;'></th>
                <th scope="col" style='background-color:#B9D5CE;'></th>
                                           
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $val):?>
            <tr style ='font-size: 85%;'>                
                <td><?= $val->codigo_juzgado ?></td>
                 <td><?= $val->nombre_juzgado ?></td>
                <td><?= $val->direccion_juzgado ?></td>
                  <td><?= $val->telefono_juzgado ?></td>
                <td><?= $val->celular_juzgado ?></td>
                <td><?= $val->email_juzgado ?></td>
                <td><?= $val->departamento->departamento ?></td>
                <td><?= $val->municipio->municipio ?></td>
                <td style= 'width: 23px; height: 23px;'>
                <a href="<?= Url::toRoute(["juzgados/view", "id" => $val->codigo_juzgado]) ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
                <td style= 'width: 23px; height: 23px;'>
                    <a href="<?= Url::toRoute(["juzgados/update", "id" => $val->codigo_juzgado]) ?>" ><span class="glyphicon glyphicon-pencil"></span></a>                   
                </td>
            </tr>            
            <?php endforeach; ?>
            </tbody>    
        </table> 
        <div class="panel-footer text-right" >            
           <?= Html::submitButton("<span class='glyphicon glyphicon-export'></span> Excel", ['name' => 'excel','class' => 'btn btn-primary btn-sm']); ?>                
           <a align="right" href="<?= Url::toRoute("juzgados/create") ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-plus'></span> Nuevo</a> 
           <?php $form->end() ?>
        </div>
     </div>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>

