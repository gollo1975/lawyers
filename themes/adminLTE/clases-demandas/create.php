<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClasesDemandas */

$this->title = 'Clases demandas';
$this->params['breadcrumbs'][] = ['label' => 'Clases Demandas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clases-demandas-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
