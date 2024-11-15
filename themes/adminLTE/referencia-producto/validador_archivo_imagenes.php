    <?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\web\Session;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use kartik\select2\Select2;
//Modelos...
$this->title = 'CARGAR IMAGEN';
$this->params['breadcrumbs'][] = $this->title;
$validador_imagen = 'referencia-producto';

$grupoReferencia = ArrayHelper::map(app\models\GrupoReferencia::find()->all(), 'id_grupo', 'concepto')
?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="panel panel-primary">
    <div class="panel-body">
        <script language="JavaScript">
            function mostrarfiltro() {
                divC = document.getElementById("filtro");
                if (divC.style.display == "none"){divC.style.display = "block";}else{divC.style.display = "none";}
            }
        </script>
        <?php $formulario = ActiveForm::begin([
            "method" => "get",
            "action" => Url::toRoute(["referencia-producto/validador_imagen"]),
            "enableClientValidation" => true,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                            'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                            'labelOptions' => ['class' => 'col-sm-2 control-label'],
                            'options' => []
                        ],
        ]);
        ?>
        <div class="panel panel-primary panel-filters">
            <div class="panel-heading" onclick="mostrarfiltro()">
                Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
            </div>
            <div class="panel-body" id="filtro" style="display:block">
                <div class="row" >
                    <?= $formulario->field($form, "codigo")->input("search") ?>
                    <?= $formulario->field($form, "referencia")->input("search") ?>
             
                    <?= $formulario->field($form, 'grupo')->widget(Select2::classname(), [
                        'data' => $grupoReferencia,
                        'options' => ['prompt' => 'Seleccione...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                    <?= $formulario->field($form, "homologado")->input("search") ?>
                </div>

                <div class="panel-footer text-right">
                    <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => 'btn btn-primary btn-sm',]) ?>
                    <a align="right" href="<?= Url::toRoute(["referencia-producto/validador_imagen"]) ?>" class="btn btn-success btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
                </div>
            </div>
        </div>
        <?php $formulario->end() ?>
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
            'fieldConfig' => [
                'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
                'options' => []
            ],
        ]); ?>
        
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#cargarimagenes" aria-controls="cargarimagenes" role="tab" data-toggle="tab">Referencias <span class="badge"><?= $pagination->totalCount ?></span></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="cargarimagenes">
                    <div class="table-responsive">
                        <div class="panel panel-primary">
                           <div class="panel-body">
                               
                                 <table class="table table-bordered table-striped table-hover">
                                   <!--  <link rel="stylesheet" href="dist/css/site.css">-->
                                    <thead>
                                        <tr style="font-size: 90%;">
                                            <th scope="col" style='background-color:#caf0f8;'>CODIGO</th>
                                            <th scope="col" style='background-color:#caf0f8;'>NOMBRE DE REFERENCIA</th>
                                             <th scope="col" style='background-color:#caf0f8;'>GRUPO</th>
                                            <th scope="col" style='background-color:#caf0f8;'>HOMOLOGADO</th>
                                            <th scope="col" style='background-color:#caf0f8;'>IMAGEN</th>
                                            <th scope="col" style='background-color:#caf0f8;'></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $cadena = '';
                                        $item = \app\models\Documentodir::findOne(1);
                                        foreach ($model as $val): 
                                            $valor = app\models\DirectorioArchivos::find()->where(['=','codigo', $val->codigo])
                                                                                          ->andWhere(['=','predeterminado', 1])->andWhere(['=','numero', $item->codigodocumento])->one();
                                            ?>
                                            <tr style ='font-size: 90%;'>                
                                                <td>R-<?= $val->codigo?></td>
                                                <td><?= $val->descripcion_referencia?></td>
                                                 <td><?= $val->grupo->concepto?></td>
                                                <td><?= $val->codigo_homologado?></td>
                                                <?php if($valor){
                                                    $cadena = 'Documentos/'.$valor->numero.'/'.$valor->codigo.'/'. $valor->nombre;
                                                    if($valor->extension == 'png' || $valor->extension == 'jpeg' || $valor->extension == 'jpg'){?>
                                                       <td  style="width: 10%; height: 20%; text-align: center; background-color: white" title="<?php echo $val->descripcion_referencia?>"> <?= yii\bootstrap\Html::img($cadena, ['width' => '100%;', 'height' => '60%;'])?></td>
                                                    <?php }else {?>
                                                        <td><?= 'NOT FOUND'?></td>
                                                    <?php } 
                                                }else{?>
                                                      <td><?= 'No found'?></td>
                                                <?php }?>      
                                                <td style="width: 5%; height: 10%">
                                                    <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Archivos', ['directorio-archivos/index_imagen','numero' => 1, 'codigo' => $val->codigo, 'validador_imagen' => $validador_imagen, 'token' => $token,], ['class' => 'btn btn-default btn-sm']) ?>
                                                </td>  
                                            </tr>            
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?= LinkPager::widget(['pagination' => $pagination]) ?>
                    </div>
                </div>    
                <!-- TERMINA TABS-->  
        </div>     
    </div>        
    <?php ActiveForm::end(); ?>    
</div> 

