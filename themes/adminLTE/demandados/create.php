<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Demandados */

$this->title = 'Demandados';
$this->params['breadcrumbs'][] = ['label' => 'Demandados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="demandados-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'token' => $token,
    ]) ?>

</div>
