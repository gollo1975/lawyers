<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompraTipo */

$this->title = 'Nuevo Compra Tipo';
$this->params['breadcrumbs'][] = ['label' => 'Compra Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-tipo-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
