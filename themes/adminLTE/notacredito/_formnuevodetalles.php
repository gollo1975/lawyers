<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\Session;
use yii\data\Pagination;
use yii\db\ActiveQuery;

/* @var $this yii\web\View */
/* @var $model app\models\Facturaventadetalle */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([

    'options' => ['class' => 'form-horizontal condensed', 'role' => 'form'],
    'fieldConfig' => [
        'template' => '{label}<div class="col-sm-5 form-group">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-sm-3 control-label'],
        'options' => []
    ],
]); ?>

<?php
if ($mensaje != ""){
    ?> <div class="alert alert-danger"><?= $mensaje ?></div> <?php
}
?>

<div class="table table-responsive">
    <div class="panel panel-success ">
        <div class="panel-heading">
            Nuevo detalle Nota Crédito
        </div>
        <div class="panel-body">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nro Factura</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha Inicio</th>
                    <th scope="col">Fecha Vcto</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Rete Fuente</th>
                    <th scope="col">Rete iva</th>
                    <th scope="col">Iva</th>
                    <th scope="col">Saldo</th>
                    <th scope="col">Total</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($notacreditoFactura as $val): ?>
                <tr>
                    <td><?= $val->idfactura ?></td>
                    <td><?= $val->nro_factura ?></td>
                    <td><?= $val->cliente->nombrecorto ?></td>
                    <td><?= $val->fecha_inicio ?></td>
                    <td><?= $val->fecha_vencimiento ?></td>
                    <td><?= '$ ' .number_format($val->subtotal,0) ?></td>
                    <td><?= '$ ' .number_format($val->retencionfuente,0) ?></td>
                    <td><?= '$ ' .number_format($val->retencioniva,0) ?></td>
                    <td><?= '$ ' .number_format($val->impuestoiva,0) ?></td>
                    <td><?= '$ ' .number_format($val->saldo,0) ?></td>
                    <td><?= '$ ' .number_format($val->totalpagar,0) ?></td>
                    <td><input type="radio" name="idfactura[]" value="<?= $val->idfactura ?>"></td>
                </tr>
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="panel-footer text-right">
            <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar', ['notacredito/view', 'id' => $idnotacredito], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-success",]) ?>
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>

