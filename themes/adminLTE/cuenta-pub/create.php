<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CuentaPub */

$this->title = 'Nuevo Cuenta Pub';
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Pub', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuenta-pub-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
