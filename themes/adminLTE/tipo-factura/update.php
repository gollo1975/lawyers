<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Facturaventatipo */

$this->title = 'Editar Tipo';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tipo_factura, 'url' => ['update', 'id' => $model->tipo_factura]];
?>
<div class="tipo-factura-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
