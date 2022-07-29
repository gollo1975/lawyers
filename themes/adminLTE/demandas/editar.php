<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Balanceo */

$this->title = 'Editar servicios ';
?>
<div class="balanceo-update">

   <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('crear_servicios', [
        'model' => $model,
        'id' => $id,
        'codigo' => $codigo,
    ]) ?>

</div>
