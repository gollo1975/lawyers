<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComprobanteEgreso */

$this->title = 'Editar documento Nro: ' . $model->id_comprobante_egreso;
$this->params['breadcrumbs'][] = ['label' => 'Comprobante Egresos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_comprobante_egreso, 'url' => ['view', 'id' => $model->id_comprobante_egreso]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="comprobante-egreso-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'municipios' => $municipios,
        'tipo' => $tipos,
        'proveedores' => $proveedores,
        'bancos' => $bancos,
    ]) ?>

</div>
