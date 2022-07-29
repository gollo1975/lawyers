<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TipoFactura;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FacturaventatipoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo de facturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-factura-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?=  $this->render('_search', ['model' => $searchModel]); ?>

    <?php $newButton = Html::a('Nuevo ' . Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']), ['create'], ['class' => 'btn btn-success']);?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [                
                'attribute' => 'tipo_factura',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [                
                'attribute' => 'concepto',
                'contentOptions' => ['class' => 'col-lg-4.5'],                
            ],
            [                
                'attribute' => 'porcentaje_retencion',
                'contentOptions' => ['class' => 'col-lg-2'],                
            ],
            [
                'attribute' => 'estado',
                'value' => function($model){
                    $orden = TipoFactura::findOne($model->tipo_factura);                    
                    return $orden->estados;
                },
                'filter' => ArrayHelper::map(TipoFactura::find()->all(),'estado','estados'),
                'contentOptions' => ['class' => 'col-lg-3'],
            ],                                   
            [
                'class' => 'yii\grid\ActionColumn',              
            ],
        ],
        'tableOptions' => ['class' => 'table table-bordered table-success'],
        'summary' => '<div class="panel panel-success "><div class="panel-heading">Registros <span class="badge"> {totalCount}</span></div>',

        'layout' => '{summary}{items}</div><div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">' . $newButton . '</div></div>',
        'pager' => [			
            'nextPageLabel' => '<i class="fa fa-forward"></i>',
            'prevPageLabel'  => '<i class="fa fa-backward"></i>',
            'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
            'firstPageLabel'  => '<i class="fa fa-fast-backward"></i>',			
        ],
		
        
    ]); ?>
</div>


