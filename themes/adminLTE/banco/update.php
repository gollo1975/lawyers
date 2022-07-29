<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banco */
use yii\helpers\ArrayHelper;

$this->title = 'Editar Banco: ' . $model->idbanco;
$this->params['breadcrumbs'][] = ['label' => 'Bancos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idbanco, 'url' => ['view', 'id' => $model->idbanco]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="banco-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
