<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Demandados */

$this->title = 'Demandados: ' . $model->documento;
$this->params['breadcrumbs'][] = ['label' => 'Demandados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->documento, 'url' => ['update', 'id' => $model->documento]];

?>
<div class="demandados-update">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'token' => $token,
        'municipio' => $municipio,
    ]) ?>

</div>
