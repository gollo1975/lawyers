<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GrupoPago */

$this->title = 'Nuevo contenido';
$this->params['breadcrumbs'][] = ['label' => 'Nuevo contenido', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formato-contenido-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
