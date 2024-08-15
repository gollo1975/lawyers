<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */

$this->title = 'Actualizar: '. $model->nombrecorto;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcliente, 'url' => ['update', 'id' => $model->idcliente]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="clientes-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form_editado', [
        'model' => $model,
        "municipio" => $municipio
    ]) ?>

</div>
