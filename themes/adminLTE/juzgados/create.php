<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Juzgados */

$this->title = 'Juzgados';
$this->params['breadcrumbs'][] = ['label' => 'Juzgados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="juzgados-create">

   <!-- <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
          'token' => $token,
    ]) ?>

</div>
