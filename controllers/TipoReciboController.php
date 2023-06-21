<?php

namespace app\controllers;

use Yii;
use app\models\TipoRecibo;
use app\models\TipoReciboSearch;
use app\models\Tiporecibocuenta;
use app\models\FormTipoReciboCuentaNuevo;
use app\models\FormReciboCajaTipoDetalleEditar;
use app\models\CuentaPub;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UsuarioDetalle;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * TipoReciboController implements the CRUD actions for TipoRecibo model.
 */
class TipoReciboController extends Controller
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
     * Lists all TipoRecibo models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',4])->all()){
                $searchModel = new TipoReciboSearch();
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
     * Displays a single TipoRecibo model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modeldetalles = Tiporecibocuenta::find()->Where(['=', 'idtiporecibo', $id])->all();
        
        if (Yii::$app->request->post()) {
            if (isset($_POST["eliminar"])) {
                if (isset($_POST["idtiporecibocuenta"])) {
                    foreach ($_POST["idtiporecibocuenta"] as $intCodigo) {
                        try {
                            $eliminar = Tiporecibocuenta::findOne($intCodigo);
                            $eliminar->delete();
                            Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
                            $this->redirect(["tipo-recibo/view", 'id' => $id]);
                        } catch (IntegrityException $e) {
                            //$this->redirect(["producto/view", 'id' => $id]);
                            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el detalle, tiene registros asociados en otros procesos');
                        } catch (\Exception $e) {
                            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el detalle, tiene registros asociados en otros procesos');
                            //$this->redirect(["producto/view", 'id' => $id]);
                        }
                    }
                    //$this->redirect(["producto/view", 'id' => $id]);
                }
            } else {
                    Yii::$app->getSession()->setFlash('error', 'Debe seleccionar al menos un registro.');
                    $this->redirect(["tipo-recibo/view", 'id' => $id]);
                   }
        }        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modeldetalles' => $modeldetalles,
        ]);
    }

    /**
     * Creates a new TipoRecibo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TipoRecibo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoRecibo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoRecibo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
            $this->redirect(["tipo-recibo/index"]);
        } catch (IntegrityException $e) {
            $this->redirect(["tipo-recibo/index"]);
            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el tipo de recibo, tiene registros asociados en otros procesos');
        } catch (\Exception $e) {            
            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el tipo de recibo, tiene registros asociados en otros procesos');
            $this->redirect(["tipo-recibo/index"]);
        }
    }
    
    public function actionNuevodetalles($idtiporecibo)
    {
        $cuentas = CuentaPub::find()->all();
        $form = new FormTipoReciboCuentaNuevo;
        $nombre = null;
        $cuenta = null;
        $mensaje = '';
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $nombre = Html::encode($form->nombre);
                $cuenta = Html::encode($form->cuenta);                
                $table = CuentaPub::find()
                        ->andFilterWhere(['like', 'nombre_cuenta', $nombre])
                        ->andFilterWhere(['like', 'codigo_cuenta', $cuenta]);                        
                $count = clone $table;
                $to = $count->count();
                $pages = new Pagination([
                    'pageSize' => 15,
                    'totalCount' => $count->count()
                ]);
                $cuentas = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();           
            } else {
                $form->getErrors();
            }                    
                    
                       
        } else {
            $table = CuentaPub::find();
            $count = clone $table;
            $to = $count->count();
            $pages = new Pagination([
                'pageSize' => 15,
                'totalCount' => $count->count()
            ]);
            $cuentas = $table
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
        }
        if (isset($_POST["codigo_cuenta"])) {
                $intIndice = 0;
                foreach ($_POST["codigo_cuenta"] as $intCodigo) {
                    $table = new Tiporecibocuenta();
                    $cuenta = CuentaPub::find()->where(['codigo_cuenta' => $intCodigo])->one();
                    $detalles = Tiporecibocuenta::find()
                        ->where(['=', 'cuenta', $cuenta->codigo_cuenta])
                        ->andWhere(['=', 'idtiporecibo', $idtiporecibo])
                        ->all();
                    $reg = count($detalles);
                    if ($reg == 0) {
                        if ($_POST["tipo"][$intIndice] == 1 or $_POST["tipo"][$intIndice] == 2){
                            $table->idtiporecibo = $idtiporecibo;
                            $table->cuenta = $cuenta->codigo_cuenta;
                            $table->tipocuenta = $_POST["tipo"][$intIndice];
                            //$table->usuariosistema = Yii::$app->user->identity->username;
                            $table->insert();
                            $this->redirect(["tipo-recibo/view", 'id' => $idtiporecibo]);
                        }else{
                            $mensaje = "Debe Ingresar el tipo de cuenta 1(débito), 2(crédito), si se ingresa valor 0 o diferente a 1 ó 2, el sistema no registra la cuenta";
                        }
                                                                                                                        
                    }
                    $intIndice++;
                }
                
            }else{
                
            }
        return $this->render('_formnuevodetalles', [
            'cuentas' => $cuentas,            
            'mensaje' => $mensaje,
            'idtiporecibo' => $idtiporecibo,
            'form' => $form,
            'pagination' => $pages,

        ]);
    }
    
    public function actionEditardetalle($idtiporecibocuenta) {
        $model = new FormReciboCajaTipoDetalleEditar;
        $cuentas = CuentaPub::find()->all();        
        $tiporecibocuenta = Tiporecibocuenta::findOne($idtiporecibocuenta);
        
        if ($model->load(Yii::$app->request->post())) {                        
            $tiporecibocuenta->cuenta = $model->cuenta;
            $tiporecibocuenta->tipocuenta = $model->tipocuenta;                           
            $tiporecibocuenta->save(false);                                      
            return $this->redirect(['tipo-recibo/view','id' => $tiporecibocuenta->idtiporecibo]);
        }
        if (Yii::$app->request->get("idtiporecibocuenta")) {
            $table = Tiporecibocuenta::find()->where(['idtiporecibocuenta' => $idtiporecibocuenta])->one();
            if ($table) {
                $model->cuenta = $table->cuenta;
                $model->tipocuenta = $table->tipocuenta;
            }    
        }
        return $this->render('_formeditardetalle', [
            'model' => $model,
            'tiporecibocuenta' => $tiporecibocuenta,
            'cuentas' => ArrayHelper::map($cuentas, "codigo_cuenta", "codigo_cuenta"),
        ]);        
    }

    /**
     * Finds the TipoRecibo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TipoRecibo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoRecibo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
