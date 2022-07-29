<?php

namespace app\controllers;

use yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use Codeception\Lib\HelperModule;
//modelos
use app\models\UsuarioDetalle;
use app\models\Demandados;
use app\models\DemandadosSearch;
use app\models\FormFiltroDemandados;



/**
 * DemandadosController implements the CRUD actions for Demandados model.
 */
class DemandadosController extends Controller
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
     * Lists all Demandados models.
     * @return mixed
     */
   public function actionIndex() {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',12])->all()){
                $form = new FormFiltroDemandados();
                $documento = null;
                $nombrecompleto = null;
                if ($form->load(Yii::$app->request->get())) {
                    if ($form->validate()) {
                        $documento = Html::encode($form->documento);
                        $nombrecompleto = Html::encode($form->nombrecompleto);
                        $table = Demandados::find()
                                ->andFilterWhere(['=', 'documento', $documento])
                                ->andFilterWhere(['like', 'nombre_completo', $nombrecompleto])
                                ->orderBy('documento desc');
                        $count = clone $table;
                        $to = $count->count();
                        $pages = new Pagination([
                            'pageSize' => 12,
                            'totalCount' => $count->count()
                        ]);
                        $model = $table
                                ->offset($pages->offset)
                                ->limit($pages->limit)
                                ->all();
                    } else {
                        $form->getErrors();
                    }
                } else {
                    $table = Demandados::find()
                            ->orderBy('documento desc');
                    $count = clone $table;
                    $pages = new Pagination([
                        'pageSize' => 12,
                        'totalCount' => $count->count(),
                    ]);
                    $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                }
                $to = $count->count();
                return $this->render('index', [
                            'model' => $model,
                            'form' => $form,
                            'pagination' => $pages,
                ]);
            }else{
                return $this->redirect(['site/sinpermiso']);
            }
        }else{
            return $this->redirect(['site/login']);
        }    
    }

    /**
     * Displays a single Demandados model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'table' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Demandados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($token = 0)
    {
        $model = new Demandados();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Demandados();
                $table->documento = $model->documento;
                $table->id_tipo_documento = $model->id_tipo_documento;
                $table->nombres = $model->nombres;
                $table->apellidos = $model->apellidos;
                $table->nombre_completo = strtoupper($model->nombres . " " . $model->apellidos);
                $table->direccion_demandado = $model->direccion_demandado;
                $table->telefono_demandado = $model->telefono_demandado;
                $table->email_demandado = $model->email_demandado;
                $table->iddepartamento = $model->iddepartamento;
                $table->idmunicipio = $model->idmunicipio;
                $table->usuario = Yii::$app->user->identity->username;
                $table->fecha_registro = date('Y-m-d');
                $table->observacion = $model->observacion;
                $table->save(false);
                return $this->redirect(['index']);
            }else{
                $model->getErrors();
            }    
        }
        return $this->render('create', [
            'model' => $model,
            'token' => $token,
        ]);
    }

    /**
     * Updates an existing Demandados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $token=1)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $table = Demandados::findOne($id);
                $table->id_tipo_documento = $model->id_tipo_documento;
                $table->nombres = $model->nombres;
                $table->apellidos = $model->apellidos;
                $table->nombre_completo = strtoupper($model->nombres . " " . $model->apellidos);
                $table->direccion_demandado = $model->direccion_demandado;
                $table->telefono_demandado = $model->telefono_demandado;
                $table->email_demandado = $model->email_demandado;
                $table->iddepartamento = $model->iddepartamento;
                $table->idmunicipio = $model->idmunicipio;
                $table->observacion = $model->observacion;
                $table->save(false);
                return $this->redirect(['index']);
            } else {
              $model->getErrors();  
            }
        }
        if (Yii::$app->request->get("id")) {
            $table = Demandados::find()->where(['documento' =>$id])->one();
            $municipio = \app\models\Municipio::find()->Where(['=', 'iddepartamento', $table->iddepartamento])->all();
            $municipio = ArrayHelper::map($municipio, "idmunicipio", "municipio");
            $model->nombres = $table->nombres;
            $model->apellidos = $table->apellidos;
            $model->direccion_demandado = $table->direccion_demandado;
            $model->telefono_demandado = $table->telefono_demandado;
            $model->email_demandado = $table->email_demandado;
            $model->iddepartamento = $table->iddepartamento;
            $model->idmunicipio = $table->idmunicipio;
            $model->observacion = $table->observacion;
        }

        return $this->render('update', [
            'model' => $model,
            'token' => $token,
            'municipio' => $municipio,
        ]);
    }

    /**
     * Deletes an existing Demandados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminar($id) {
        if (Yii::$app->request->post()) {
            $demandado = Demandados::findOne($id);
            if ((int) $id) {
                try {
                    Demandados::deleteAll("documento=:documento", [":documento" => $id]);
                    Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
                    $this->redirect(["abogados/index"]);
                } catch (IntegrityException $e) {
                    $this->redirect(["demandados/index"]);
                    Yii::$app->getSession()->setFlash('error', 'Error al eliminar el demandado ' . $ademandado->documento - $demandado->nombre_completo . ' tiene registros asociados en otros procesos');
                } catch (\Exception $e) {

                    $this->redirect(["demandados/index"]);
                    Yii::$app->getSession()->setFlash('error', 'Error al eliminar el demandado ' . $demandado->documento - $demandado->nombre_completo . ' tiene registros asociados en otros procesos');
                }
            } else {
                // echo "Ha ocurrido un error al eliminar el cliente, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("demandados/index") . "'>";
            }
        } else {
            return $this->redirect(["demandados/index"]);
        }
    }

    /**
     * Finds the Demandados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Demandados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Demandados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
