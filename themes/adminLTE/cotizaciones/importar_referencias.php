<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Ordenproduccion;
use app\models\TiposMaquinas;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = 'REFERENCIAS';
$this->params['breadcrumbs'][] = ['label' => 'Referencias', 'url' => ['view', 'id' => $id, 'token' => $token]];
$this->params['breadcrumbs'][] = $id;

$Buscar = ArrayHelper::map(app\models\GrupoReferencia::find()->all(), 'id_grupo', 'concepto');

?>
    <div class="modal-body">
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['view', 'id' => $id, 'token' => $token], ['class' => 'btn btn-primary btn-sm']) ?>
        </p>
        
        <?php $formulario = ActiveForm::begin([
            "method" => "get",
            "action" => Url::toRoute(["cotizaciones/cargar_nueva_referencia", 'id' => $id, 'token' => $token]),
            "enableClientValidation" => true,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                            'template' => '{label}<div class="col-sm-4 form-group">{input}{error}</div>',
                            'labelOptions' => ['class' => 'col-sm-2 control-label'],
                            'options' => []
                        ],

        ]);
        ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <div class="panel panel-primary panel-filters">
            <div class="panel-heading">
                Filtros de busqueda <i class="glyphicon glyphicon-filter"></i>
            </div>

            <div class="panel-body" id="filtrocliente">
                <div class="row" >
                    <?= $formulario->field($form, "referencia")->input("search") ?>
                    <?= $formulario->field($form, 'clasificacion')->widget(Select2::classname(), [
                        'data' => $Buscar,
                        'options' => ['prompt' => 'Seleccione...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="panel-footer text-right">
                    <?= Html::submitButton("<span class='glyphicon glyphicon-search'></span> Buscar", ["class" => "btn btn-primary btn-sm",]) ?>
                     <a align="right" href="<?= Url::toRoute(["cotizaciones/cargar_nueva_referencia", 'id' => $id, 'token' => $token]) ?>" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-refresh'></span> Actualizar</a>
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
        <div class="table table-responsive">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    Productos <span class="badge"><?= $pagination->totalCount ?></span>
                </div>
                <div class="panel-body">
                     <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col" style='background-color:#caf0f8;'>CODIGO</th>
                                <th scope="col" style='background-color:#caf0f8;'>NOMBRE DE LA REFERENCIA</th>
                                <th scope="col" style='background-color:#caf0f8;'>IMAGEN</th>
                                <th scope="col" style='background-color:#caf0f8;'>COSTO REFERENCIA</th>
                                 <th scope="col" style='background-color:#caf0f8;'>CLASIFICACION</th>
                                <th scope="col" style='background-color:#caf0f8;'><input type="checkbox" onclick="marcar(this);"/></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cadena = '';
                                        $item = \app\models\Documentodir::findOne(1);
                            foreach ($operacion as $val): 
                                $valor = app\models\DirectorioArchivos::find()->where(['=','codigo', $val->codigo])
                                                                  ->andWhere(['=','predeterminado', 1])->andWhere(['=','numero', $item->codigodocumento])->one();
                                ?>
                                <tr style="font-size: 85%;">
                                    <td>R-<?= $val->codigo ?></td>
                                    <td><?= $val->descripcion_referencia ?></td>
                                    <?php if($valor){
                                        $cadena = 'Documentos/'.$valor->numero.'/'.$valor->codigo.'/'. $valor->nombre;
                                        if($valor->extension == 'png' || $valor->extension == 'jpeg' || $valor->extension == 'jpg'){?>
                                           <td  style="width: 10%; height: 20%; text-align: center; background-color: white" title="<?php echo $val->descripcion_referencia?>"> <?= yii\bootstrap\Html::img($cadena, ['width' => '80%;', 'height' => '80%;'])?></td>
                                        <?php }else {?>
                                            <td><?= 'NOT FOUND'?></td>
                                        <?php } 
                                    }else{?>
                                          <td><?= 'No found'?></td>
                                    <?php }?>      
                                    <td style="text-align: right"><?= ''. number_format($val->costo_producto,0) ?></td>
                                    <td><?= $val->grupo->concepto ?></td>
                                    <td style= 'width: 25px; height: 25px;'><input type="checkbox" name="codigo_referencia[]" value="<?= $val->codigo ?>"></td> 
                                </tr>
                            <?php endforeach; ?>
                        </tbody>     
                    </table>
                </div>
                <div class="panel-footer text-right">
                    <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Enviar datos", ["class" => "btn btn-success btn-sm", 'name' => 'enviar_referencias']) ?>
                </div>

            </div>
            <?= LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
        
    </div>
<?php ActiveForm::end(); ?>
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
