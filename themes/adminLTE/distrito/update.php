<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Distritos: ' . $model->id_distrito;
$this->params['breadcrumbs'][] = ['label' => 'Distritos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_distrito, 'url' => ['view', 'id' => $model->id_distrito]];
?>
<div class="distrito-update">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
