<?php

namespace app\controllers;

use Yii;
use app\models\Matriculaempresa;
use app\models\Departamento;
use app\models\Municipio;
use app\models\MatriculaempresaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UsuarioDetalle;

/**
 * ArlController implements the CRUD actions for Arl model.
 */
class EmpresaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    
    /**
     * Updates an existing Arl model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEmpresa($id)
    {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso', 8])->all()){
                $model = $this->findModel($id);
                if ($model->load(Yii::$app->request->post())) {
                    $model->save();
                    if($model->id_tipo_regimen == 1){
                        if($model->razonsocialmatricula == ''){
                           Yii::$app->getSession()->setFlash('warning', 'Favor digitar el nombre de la empresa.'); 
                           return $this->redirect(['empresa','id' => $id]);
                        }else{
                            $model->nombre_completo = strtoupper($model->razonsocialmatricula);
                            $model->nombrematricula = '';
                            $model->apellidomatricula = '';
                            $model->save();
                        }    
                    }else {
                         if($model->nombrematricula == '' && $model->apellidomatricula == ''){
                             Yii::$app->getSession()->setFlash('warning', 'Favor digitar el nombre de la persona natural.'); 
                             return $this->redirect(['empresa', 'id' => $id]);
                        }else{
                            $model->nombre_completo = strtoupper($model->nombrematricula. " " . $model->apellidomatricula);
                            $model->razonsocialmatricula = '';
                            $model->save();
                        }    
                    }
                   
                }
                return $this->render('empresa', [
                    'model' => $model,
                ]);
            }else{
                return $this->redirect(['site/sinpermiso']);
            }
        }else{
            return $this->redirect(['site/login']);
        }
    }
    

    /**
     * Finds the Arl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Arl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Matriculaempresa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionMunicipio($id) {
        $rows = Municipio::find()->where(['iddepartamento' => $id])->all();

        echo "<option required>Seleccione...</option>";
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                echo "<option value='$row->idmunicipio' required>$row->municipio</option>";
            }
        }
    }
}
