<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Departamentos;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MunicipioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'DOCUMENTOS';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="tipo-documento-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?=  $this->render('_search', ['model' => $searchModel]); ?>

    <?php $newButton = Html::a('Nuevo ' . Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']), ['create'], ['class' => 'btn btn-primary btn-sm']);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [                
                'attribute' => 'id_tipo_documento',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [                
                'attribute' => 'tipo',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [
                'attribute' => 'descripcion',
                'contentOptions' => ['class' => 'col-lg-2'],
            ],
             [
                'attribute' => 'codigo_interfaz',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            
             [
                'class' => 'yii\grid\ActionColumn', 
                 'contentOptions' => ['class' => 'col-lg-1'],
            ],            
			
        ],
        'tableOptions' => ['class' => 'table table-bordered table-success'],
        'summary' => '<div class="panel panel-primary "><div class="panel-heading">Registros <span class= "badge"> {totalCount}</span></div>',

        'layout' => '{summary}{items}</div><div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">' . $newButton . '</div></div>',
        'pager' => [
            'nextPageLabel' => '<i class="fa fa-forward"></i>',
            'prevPageLabel'  => '<i class="fa fa-backward"></i>',
            'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
            'firstPageLabel'  => '<i class="fa fa-fast-backward"></i>'
        ],
        
    ]); ?>
</div>


