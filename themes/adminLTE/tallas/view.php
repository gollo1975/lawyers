<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Municipio */

$this->title = 'TALLAS';
$this->params['breadcrumbs'][] = ['label' => 'tallas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id_talla;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="tallas-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', ['update', 'id' => $model->id_talla], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading">
            TALLAS
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
               <tr style ='font-size:90%;'>
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'id_talla') ?>:</th>
                    <td><?= Html::encode($model->id_talla) ?></td>                    
                    <th style='background-color:#F0F3EF;'><?= Html::activeLabel($model, 'nombre_talla') ?>:</th>
                    <td><?= Html::encode($model->nombre_talla) ?></td>
          
              </tr>
            </table>
        </div>
    </div>

</div>