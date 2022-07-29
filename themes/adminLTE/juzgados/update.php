<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Juzgados */

$this->title = 'Juzgados: ' . $model->codigo_juzgado;
$this->params['breadcrumbs'][] = ['label' => 'Juzgados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo_juzgado, 'url' => ['view', 'id' => $model->codigo_juzgado]];
?>
<div class="juzgados-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'token' => $token,
    ]) ?>

</div>
