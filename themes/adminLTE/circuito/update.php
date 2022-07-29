<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Circuito */

$this->title = 'Circuitos: ' . $model->id_circuito;
$this->params['breadcrumbs'][] = ['label' => 'Circuitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_circuito, 'url' => ['view', 'id' => $model->id_circuito]];
?>
<div class="circuito-update">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
