<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContabilidadComprobanteTipo */

$this->title = 'Nuevo Comprobante Tipo (Exportar)';
$this->params['breadcrumbs'][] = ['label' => 'Comprobantes Tipo (Exportar)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contabilidad-comprobante-tipo-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
