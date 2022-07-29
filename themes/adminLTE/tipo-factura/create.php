<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Facturaventatipo */

$this->title = 'Nuevo tipo';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de factura', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-factura-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>