<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompraTipo */

$this->title = 'Editar Compra Tipo: ' . $model->id_compra_tipo;
$this->params['breadcrumbs'][] = ['label' => 'Compra Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_compra_tipo, 'url' => ['view', 'id' => $model->id_compra_tipo]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="compra-tipo-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
