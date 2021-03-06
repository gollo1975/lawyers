<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComprobanteEgreso */

$this->title = 'Nuevo Comprobante';
$this->params['breadcrumbs'][] = ['label' => 'Comprobante Egresos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comprobante-egreso-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'municipios' => $municipios,
        'tipo' => $tipos,
        'proveedores' => $proveedores,
        'bancos' => $bancos,
    ]) ?>

</div>
