<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Especialidades */

$this->title = 'Especialidades: ' . $model->id_especialidad;
$this->params['breadcrumbs'][] = ['label' => 'Especialidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_especialidad, 'url' => ['view', 'id' => $model->id_especialidad]];
?>
<div class="especialidades-update">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
