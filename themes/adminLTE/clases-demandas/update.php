<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClasesDemandas */

$this->title = 'Clases demandas: ' . $model->id_clase_demanda;
$this->params['breadcrumbs'][] = ['label' => 'Clases Demandas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_clase_demanda, 'url' => ['view', 'id' => $model->id_clase_demanda]];

?>
<div class="clases-demandas-update">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
