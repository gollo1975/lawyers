<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\BancoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Juez';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="juez-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?=  $this->render('_search', ['model' => $searchModel]); ?>

    <?php $newButton = Html::a('Nuevo ' . Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']), ['create'], ['class' => 'btn btn-success btn-sm']);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            [                
                'attribute' => 'id_juez',
                'contentOptions' => ['class' => 'col-lg-2'],
            ],
            [                
                'attribute' => 'nombre_juez',
                'contentOptions' => ['class' => 'col-lg-6'],                
            ],
            [               
                 'attribute' => 'estado_juez',
                'value' => function($model) {
                    $estado_juez = \app\models\Juez::findOne($model->id_juez);
                    return $estado_juez->validarjuez;
                },
                'filter' => ArrayHelper::map(\app\models\Juez::find()->all(), 'estado_juez', 'validarjuez'),        
                'contentOptions' => ['class' => 'col-lg-3'],     
            ],
            [
                'class' => 'yii\grid\ActionColumn',              
            ],
			
        ],
        //'tableOptions' => ['class' => 'table table-success'],
        'tableOptions'=>['class'=>'table table-bordered table-success'],        
        'summary' => '<div class="panel panel-success "><div class="panel-heading">Registros <span class="badge">  {totalCount}</span></div>',

        'layout' => '{summary}{items}</div><div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">' . $newButton . '</div></div>',
        'pager' => [
            'nextPageLabel' => '<i class="fa fa-forward"></i>',
            'prevPageLabel'  => '<i class="fa fa-backward"></i>',
            'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
            'firstPageLabel'  => '<i class="fa fa-fast-backward"></i>'
        ],
        
    ]); ?>
</div>


