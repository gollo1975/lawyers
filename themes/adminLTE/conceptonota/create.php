<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Conceptonota */

$this->title = 'Nuevo Concepto Nota';
$this->params['breadcrumbs'][] = ['label' => 'Conceptos Notas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conceptonota-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
