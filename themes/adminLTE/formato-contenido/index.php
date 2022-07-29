<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\ConfiguracionFormatoPrefijo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GrupoPagoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contenidos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupo-pago-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?php $newButton = Html::a('Nuevo ' . Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']), ['create'], ['class' => 'btn btn-success']); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id_formato_contenido',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [
                'attribute' => 'nombre_formato',
                'contentOptions' => ['class' => 'col-lg-4.5'],
            ],
            [
                'attribute' => 'id_configuracion_prefijo',
                'value' => function($model){
                   $nombreprefijo = ConfiguracionFormatoPrefijo::findOne($model->id_configuracion_prefijo);
                   return $nombreprefijo->formato;
                },
                'filter' => ArrayHelper::map(ConfiguracionFormatoPrefijo::find()->all(),'id_configuracion_prefijo','formato'),
                'contentOptions' => ['class' => 'col-lg-2'],
            ],
            [
                'attribute' => 'usuariosistema',
                'contentOptions' => ['class' => 'col-lg-1'],
            ],
            [
                'attribute' => 'fecha_creacion',
                'contentOptions' => ['class' => 'col-lg-2'],
            ],                 
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
        'tableOptions' => ['class' => 'table table-bordered table-success'],
        'summary' => '<div class="panel panel-success "><div class="panel-heading">Registros:<span class="badge"> {totalCount}</span></div>',
        'layout' => '{summary}{items}</div><div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">' . $newButton . '</div></div>',
        'pager' => [
            'nextPageLabel' => '<i class="fa fa-forward"></i>',
            'prevPageLabel' => '<i class="fa fa-backward"></i>',
            'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
            'firstPageLabel' => '<i class="fa fa-fast-backward"></i>',
        ],
    ]);
    ?>
</div>