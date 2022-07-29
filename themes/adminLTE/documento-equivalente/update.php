<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentoEquivalente */
use yii\helpers\ArrayHelper;

$this->title = 'Editar Documento: ' . $model->consecutivo;
$this->params['breadcrumbs'][] = ['label' => 'Documentos Equivalentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->consecutivo, 'url' => ['view', 'id' => $model->consecutivo]];
?>
<div class="banco-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
