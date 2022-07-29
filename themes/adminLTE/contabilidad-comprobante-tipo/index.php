<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\ContabilidadComprobanteTipo;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ContabilidadComprobanteTipoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista Contabilidad Comprobante Tipos (Exportar)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contabilidad-comprobante-tipo-index">
    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?=  $this->render('_search', ['model' => $searchModel]); ?>

    <?php $newButton = Html::a('Nuevo ' . Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']), ['create'], ['class' => 'btn btn-success']);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            [                
                'attribute' => 'id_contabilidad_comprobante_tipo',
                'contentOptions' => ['class' => 'col-lg-2'],
            ],
            [                
                'attribute' => 'tipo',
                'contentOptions' => ['class' => 'col-lg-3'],                
            ],
            [                
                'attribute' => 'codigo',
                'contentOptions' => ['class' => 'col-lg-3'],                
            ],
            [
                'attribute' => 'estado',
                'value' => function($model){
                    $tipo = ContabilidadComprobanteTipo::findOne($model->id_contabilidad_comprobante_tipo);                    
                    return $tipo->activo;
                },
                'filter' => ArrayHelper::map(app\models\ComprobanteEgresoTipo::find()->all(),'estado','activo'),
                'contentOptions' => ['class' => 'col-lg-3'],
            ],            
            [
                    'class' => 'yii\grid\ActionColumn',              
                ],

            ],
            //'tableOptions' => ['class' => 'table table-success'],
            'tableOptions'=>['class'=>'table table-bordered table-success'],        
            'summary' => '<div class="panel panel-success "><div class="panel-heading">Registros: {totalCount}</div>',

            'layout' => '{summary}{items}</div><div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">' . $newButton . '</div></div>',
            'pager' => [
                'nextPageLabel' => '<i class="fa fa-forward"></i>',
                'prevPageLabel'  => '<i class="fa fa-backward"></i>',
                'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
                'firstPageLabel'  => '<i class="fa fa-fast-backward"></i>'
            ],

        ]); ?>
</div>