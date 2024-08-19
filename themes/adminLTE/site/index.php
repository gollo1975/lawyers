<?php
use yii\bootstrap;
use yii\bootstrap\Html;
use app\models\Matriculaempresa;
use app\models\Municipio;
use app\models\Departamento;
/* @var $this yii\web\View */
$empresa = \app\models\Matriculaempresa::findOne(1);
$municipio = \app\models\Municipio::find()->all();
$departamento = Departamento::find()->all();
$cliente = \app\models\Cliente::find()->all();
$cotizacion = app\models\Cotizaciones::find()->all();
$this->params['breadcrumbs'][] = ['label' => 'COTIZACIONES SJ', 'url' => ['index']];
$this->title = $empresa->nombresistema;
?>

<div class="panel panel-primary">
     <div class="panel-heading ">
          <h1>Sistema de Cotizacion</h1>
     </div>
    <div class="panel-body">
       
        <table class="table table-responsive align-center">
            <head>
            <br>
            <br>
             <br>
                <tr>
                
                </tr>
            </head> 
             <br>
              <br>
              <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-light-blue">
                                <div class="inner">
                                    <h4 style="text-align: center; color: #FFFFFF;"><span class='glyphicon glyphicon-home'> <font face="arial">MUNICIPIOS</font></span></h4>  
                                    <h3 style="text-align: center;"><?= count($municipio)?></h3>
                                </div>
                                <div class="icon">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-aqua-gradient">
                                <div class="inner">
                                    <h4 style="text-align: center; color: #FFFFFF;"><span class='glyphicon glyphicon-list-alt'> <font face="arial">DEPARTAMENTOS</font></span></h4>  
                                    <h3 style="text-align: center;"><?= count($departamento)?></h3>
                                </div>
                                <div class="icon">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-aqua-active">
                                <div class="inner">
                                    <h4 style="text-align: center; color: #FFFFFF;"><span class='glyphicon glyphicon-list'> <font face="arial">COTIZACIONES</font></span></h4>  
                                    <h3 style="text-align: center;"><?= count($cotizacion)?></h3>
                                </div>
                                <div class="icon">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-purple-gradient">
                                <div class="inner">
                                    <h4 style="text-align: center; color: #FFFFFF;"><span class='glyphicon glyphicon-user'> <font face="arial">CLIENTES</font></span></h4>  
                                    <h3 style="text-align: center;"><?= count($cliente)?></h3>
                                </div>
                                <div class="icon">
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>  
                  
             </section>        

        </table>
    </div>    

</div>    

<!--<!-- comment -->

<div class="panel panel-primary">
        <div class="login-logo">
            <a href="#"></a>
       </div>
    <div class="panel-body">
        <div class="panel-body">
            <table class="table table-bordered table-striped table-hover">
                 <section class="content">
    <div class="container-fluid" style="text-align: center">
        <!-- Small boxes (Stat box) -->
    
      </div>
    </section> 
            </table>
        </div> 
    </div>    
  
        

<!-- Remove the container if you want to extend the Footer to full width. -->
   <div class="container my-2">

        <!-- Footer -->
        <footer>

        </footer>
        <!-- Footer -->

    </div>
    </div>
</div>   

  
        <footer class="main-footer">
            <div class="text-center p-5">    
                <strong>Copyright &copy; 2024 <a href="https://diamantesj.com">DIAMANTE SJ</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                  <b>Version</b> 1.0
                </div>
            </div>    
          </footer>
    
    

