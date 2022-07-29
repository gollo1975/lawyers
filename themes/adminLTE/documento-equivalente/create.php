<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Documento Equivalente */

$this->title = 'Nuevo Documento';
$this->params['breadcrumbs'][] = ['label' => 'Documentos Equivalantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banco-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
