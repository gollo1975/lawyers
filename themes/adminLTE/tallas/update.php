<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tallas */

$this->title = 'Actualizar: ' . $model->nombre_talla;
$this->params['breadcrumbs'][] = ['label' => 'Tallas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_talla, 'url' => ['update', 'id' => $model->id_talla]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tallas-update">

 <!--  <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
