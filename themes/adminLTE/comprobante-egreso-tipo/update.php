<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComprobanteEgresoTipo */

$this->title = 'Editar Comprobante: ' . $model->id_comprobante_egreso_tipo;
$this->params['breadcrumbs'][] = ['label' => 'Comprobante Egreso Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_comprobante_egreso_tipo, 'url' => ['view', 'id' => $model->id_comprobante_egreso_tipo]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="comprobante-egreso-tipo-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
