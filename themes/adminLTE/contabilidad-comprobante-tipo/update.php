<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContabilidadComprobanteTipo */

$this->title = 'Editar Contabilidad Comprobante Tipo (Exportar): ' . $model->id_contabilidad_comprobante_tipo;
$this->params['breadcrumbs'][] = ['label' => 'Contabilidad Comprobantes Tipo (Exportar)', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_contabilidad_comprobante_tipo, 'url' => ['view', 'id' => $model->id_contabilidad_comprobante_tipo]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="contabilidad-comprobante-tipo-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
