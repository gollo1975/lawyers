<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TallasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tallas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

   
    <?php ActiveForm::end(); ?>

</div>
