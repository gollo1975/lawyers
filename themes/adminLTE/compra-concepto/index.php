<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\CompraConcepto;
use app\models\CompraTipo;
use app\models\Compra;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompraConceptoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Conceptos Compra';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compraConcepto-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?=  $this->render('_search', ['model' => $searchModel]); ?>

    <?php $newButton = Html::a('Nuevo ' . Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']), ['create'], ['class' => 'btn btn-success']);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            [                
                'attribute' => 'id_compra_concepto',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [               
                'attribute' => 'concepto',
                'contentOptions' => ['class' => 'col-lg-2.5'],                
            ],
            [
                'attribute' => 'id_compra_tipo',
                'value' => function($model){
                    $tipo = CompraTipo::findOne($model->id_compra_tipo);
                    return $tipo->tipo;
                },
                'filter' => ArrayHelper::map(CompraTipo::find()->all(),'id_compra_tipo','tipo'),
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [               
                'attribute' => 'cuenta',
                'contentOptions' => ['class' => 'col-lg-1 '],                
            ],
            [                
                'attribute' => 'base_retencion',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [                
                'attribute' => 'porcentaje_iva',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [                
                'attribute' => 'porcentaje_retefuente',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [                
                'attribute' => 'porcentaje_reteiva',
                'contentOptions' => ['class' => 'col-lg-0.5'],
            ],
            [                
                'attribute' => 'base_aiu',
                'contentOptions' => ['class' => 'col-lg-0.5'],
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


