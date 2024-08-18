<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cotizaciones */

$this->title = 'Actualizar: ' . $model->cliente->nombrecorto;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_cotizacion, 'url' => ['update', 'id' => $model->id_cotizacion]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cotizaciones-update">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
