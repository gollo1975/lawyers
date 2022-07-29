<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Balanceo */

$this->title = 'Editar actuación ';
?>
<div class="balanceo-update">

   <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('crear_notificacion', [
        'model' => $model,
        'id' => $id,
        'codigo' => $codigo,
    ]) ?>

</div>
