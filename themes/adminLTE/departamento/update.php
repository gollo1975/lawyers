<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Departamento */

$this->title = 'Actualizar: ' . $model->departamento;
$this->params['breadcrumbs'][] = ['label' => 'Departamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iddepartamento, 'url' => ['update', 'id' => $model->iddepartamento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="departamento-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'sw' => 1,
    ]) ?>

</div>
