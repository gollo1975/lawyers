<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Facturaventa */

$this->title = 'Factura de venta';
$this->params['breadcrumbs'][] = ['label' => 'Factura venta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturaventa-create">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'demandas' => $demandas,
        'tipo_factura' => $tipo_factura,
        'clientes' => $clientes,
        'config' => $config,
    ]) ?>

</div>
