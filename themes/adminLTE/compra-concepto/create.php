<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompraConcepto */

$this->title = 'Nuevo Concepto';
$this->params['breadcrumbs'][] = ['label' => 'Conceptos Compra', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-concepto-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'tipos' => $tipos,
    ]) ?>

</div>
