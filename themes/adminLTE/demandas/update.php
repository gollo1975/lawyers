<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Demandas */

$this->title = 'Demandas: ' . $model->nro_demanda;
$this->params['breadcrumbs'][] = ['label' => 'Demandas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nro_demanda, 'url' => ['update', 'id' => $model->nro_demanda]];
?>
<div class="demandas-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
