<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Abogados */

$this->title = 'Abogados';
$this->params['breadcrumbs'][] = ['label' => 'Abogados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="abogados-create">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'token' => $token,
    ]) ?>

</div>
