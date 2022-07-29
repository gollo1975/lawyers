<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompraConcepto */

$this->title = 'Editar Concepto: ' . $model->id_compra_concepto;
$this->params['breadcrumbs'][] = ['label' => 'Conceptos Compra', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_compra_concepto, 'url' => ['view', 'id' => $model->id_compra_concepto]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="compra-concepto-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'tipos' => $tipos,
    ]) ?>

</div>
