<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CuentaPub */

$this->title = 'Editar Cuenta Pub: ' . $model->codigo_cuenta;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Pub', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo_cuenta, 'url' => ['view', 'id' => $model->codigo_cuenta]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="cuenta-pub-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
