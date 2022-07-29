<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Juez */

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = ['label' => 'Juez', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_juez, 'url' => ['update', 'id' => $model->id_juez]];
?>
<div class="juez-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
