<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoFactura */

$this->title = 'Create Tipo Factura';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-factura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
