<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GrupoPago */

$this->title = 'Contenido Nro: ' . $model->id_formato_contenido;
$this->params['breadcrumbs'][] = ['label' => 'Contedio principal', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_formato_contenido, 'url' => ['view', 'id' => $model->id_formato_contenido]];
$this->params['breadcrumbs'][] = 'Editar cotenido';
?>
<div class="formato-contenido-update">

     <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
