<?php

namespace app\controllers;
//modelos
use app\models\FormatoContenido;
use app\models\FormatoContenidoSearch;
use app\models\UsuarioDetalle;
//clases
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\ActiveQuery;
use yii\base\Model;
use yii\web\Response;
use yii\web\Session;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use Codeception\Lib\HelperModule;

/**
 * FormatoContenidoController implements the CRUD actions for FormatoContenido model.
 */
class FormatoContenidoController extends Controller
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
     * Lists all FormatoContenido models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',32])->all()){
                $searchModel = new FormatoContenidoSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
        }else{
                return $this->redirect(['site/sinpermiso']);
            }
        }else{
            return $this->redirect(['site/login']);
        }         
    }


    /**
     * Displays a single FormatoContenido model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FormatoContenido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FormatoContenido();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        $prefijo = \app\models\ConfiguracionFormatoPrefijo::find()->all();
        if ($model->load(Yii::$app->request->post())){
            if ($model->validate()) {
                if($prefijo){
                    $table=  new FormatoContenido();
                    $table->nombre_formato = $model->nombre_formato;
                    $table->contenido = $model->contenido;
                    $table->id_configuracion_prefijo = $model->id_configuracion_prefijo;
                     $table->usuariosistema = Yii::$app->user->identity->username; 
                    $table->save(false); 
                    return $this->redirect(["formato-contenido/index"]); 
                }else{
                  Yii::$app->getSession()->setFlash('error', 'No existe el documento del empleado.'); 
                }
           }else{
               $model->getErrors();
           }
        }   
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FormatoContenido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id_formato_contenido]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FormatoContenido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminar($id) {
        
        if (Yii::$app->request->post()) {
            $formato = FormatoContenido::findOne($id);
            if ((int) $id) {
                try {
                    FormatoContenido::deleteAll("id_formato_cotenido=:id_formato_cotenido", [":id_formato_cotenido" => $id]);
                    Yii::$app->getSession()->setFlash('success', 'Registro Eliminado con exito.');
                    $this->redirect(["formato-contenido/index"]);
                } catch (IntegrityException $e) {
                    $this->redirect(["formato-contenido/index"]);
                    Yii::$app->getSession()->setFlash('error', 'Error al eliminar el formato Nro :' .$formato->id_formato_cotenido .', tiene registros asociados en otros procesos');
                } catch (\Exception $e) {

                    $this->redirect(["formato-contenido/index"]);
                    Yii::$app->getSession()->setFlash('error', 'Error al eliminar el credito Nro: ' . $formato->id_formato_contenido . ', tiene registros asociados en otros procesos');
                }
            } else {
                // echo "Ha ocurrido un error al eliminar el registros, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("formato-contenido/index") . "'>";
            }
        } else {
            return $this->redirect(["formato-contenido/index"]);
        }
    }

    /**
     * Finds the FormatoContenido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FormatoContenido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FormatoContenido::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
