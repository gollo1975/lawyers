<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TipoRecibo */

$this->title = 'Nuevo Tipo Recibo';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Recibos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-documento-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
