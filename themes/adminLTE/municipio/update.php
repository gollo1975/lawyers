<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Municipio */

$this->title = 'Editar Municipio: ' . $model->idmunicipio;
$this->params['breadcrumbs'][] = ['label' => 'Municipios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idmunicipio, 'url' => ['view', 'id' => $model->idmunicipio]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="municipio-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
