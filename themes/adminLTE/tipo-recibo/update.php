<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoRecibo */

$this->title = 'Editar Tipo Recibo: ' . $model->idtiporecibo;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Recibos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idtiporecibo, 'url' => ['view', 'id' => $model->idtiporecibo]];
$this->params['breadcrumbs'][] = 'Editar Tipo Recibo';
?>
<div class="tipo Recibo-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
