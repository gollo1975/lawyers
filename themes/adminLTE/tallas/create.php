<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tallas */

$this->title = 'Nueva';
$this->params['breadcrumbs'][] = ['label' => 'Tallas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tallas-create">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
