<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
               
             
                <!-- Tasks: style can be found in dropdown.less -->
                
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/avatar5.png" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->nombrecompleto ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= Yii::$app->user->identity->nombrecompleto ?> - <?= Yii::$app->user->identity->emailusuario ?>
                                <small><?php if (Yii::$app->user->identity->role == 2){ echo "Administrador"; } else {echo "Usuario";} ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Datos</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">otros</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Config</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php if (Yii::$app->user->identity->role == 2) { ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-user"></span> Perfil', ['site/users'], ['class' => 'btn btn-default']) ?>
                                <?php } else { ?>
                                    <?= Html::a('Perfil', ['site/view', 'id' => Yii::$app->user->identity->codusuario], ['class' => 'btn btn-primary']) ?>
                                <?php } ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    '<span class="glyphicon glyphicon-off"></span> Cerrar Sesión',                                    
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-primary']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
