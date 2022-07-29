<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Matriculaempresa;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Iniciar Sesión';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <?php $empresa = Matriculaempresa::findOne(1) ;?>
        
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
         <div class="panel panel-success">
            <div class="panel-heading">
                <td colspan="2"></td><span class="badge"><h4>Iniciar sesión</h4></span>
            </div>
             <br>
             <br>

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

            <?= $form
                ->field($model, 'username', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

            <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= Html::submitButton("<span class='glyphicon glyphicon-share'></span> Conectar", ['name' => 'login-button','class' => 'btn btn-success btn-sm']); ?>                
                </div>
                <!-- /.col -->
            </div>
            <br>
            <br>        
            <div class="row" align="center">
                <img src="dist/images/logos/logolayers.png" align="center" width="40%" height="50%">
            </div>
            <?php ActiveForm::end(); ?>
       </div>
    </div>
    
</div><!-- /.login-box -->

