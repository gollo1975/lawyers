<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Conceptonota */

$this->title = 'Editar Concepto Nota: ' . $model->idconceptonota;
$this->params['breadcrumbs'][] = ['label' => 'Conceptos Notas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idconceptonota, 'url' => ['view', 'id' => $model->idconceptonota]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="conceptonota-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
