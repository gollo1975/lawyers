<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Facturaventa */

$this->title = 'Factura venta: ' . $model->idfactura;
$this->params['breadcrumbs'][] = ['label' => 'Factura venta', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idfactura, 'url' => ['view', 'id' => $model->idfactura]];
?>
<div class="facturaventa-update">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'clientes' => $clientes,
        'demandas' => $demandas,
        'tipo_factura' => $tipo_factura,
        'config' => $config,
    ]) ?>

</div>
