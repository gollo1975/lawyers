<?php
use yii\bootstrap;
use yii\bootstrap\Html;
use app\models\Matriculaempresa;
/* @var $this yii\web\View */
$empresa = Matriculaempresa::findOne(1);
$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Panel', 'url' => ['index']];
?>
<div class="jumbotron">
     <h1>Bienvenidos!</h1>
     <img src="dist/images/logos/logolayers.png" align ='center' width="150px;" height="150px;">
</div>
<div class="site-index">
    <div class="panel panel-success">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                   <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <h3>HISTORIA</h3>
                   </a>
                </h4>    
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <tr style="font-family: 200px;"> 
                           <?= $empresa->historia;?>
                        </tr>    
                    </table>
                </div>    
            </div>
        </div>    
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                       <h3>MISION</h3>
                    </a>
                </h4>    
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <tr style="font-family: 200px;"> 
                           <?= $empresa->mision;?>
                        </tr>    
                    </table>
                </div>    
            </div>
       </div>
         <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h3>VISION</h3>
                    </a>
                </h4>    
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <tr style="font-family: 200px;"> 
                           <?= $empresa->vision;?>
                        </tr>    
                    </table>
                </div>    
            </div>
       </div>
    </div>
    </div>      
</div>
