<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Abogados */

$this->title = 'Abogados: ' . $model->documento;
$this->params['breadcrumbs'][] = ['label' => 'Abogados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->documento, 'url' => ['update', 'id' => $model->documento]];
?>
<div class="abogados-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'token' => $token,
        'municipio' => $municipio,
    ]) ?>

</div>
