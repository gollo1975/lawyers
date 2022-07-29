<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoFactura */

$this->title = 'Update Tipo Factura: ' . $model->tipo_factura;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tipo_factura, 'url' => ['view', 'id' => $model->tipo_factura]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-factura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
