<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = 'Editar Compra: ' . $model->id_compra;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_compra, 'url' => ['view', 'id' => $model->id_compra]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="compra-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'proveedores' => $proveedores,
        'conceptos' => $conceptos,
        'tipocompra' => $tipocompra,
    ]) ?>

</div>
