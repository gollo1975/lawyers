<?php

namespace app\controllers;

use Yii;
use app\models\ComprobanteEgresoTipo;
use app\models\ComprobanteEgresoTipoSearch;
use app\models\UsuarioDetalle;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CuentaPub;
use app\models\ComprobanteEgresoTipoCuenta;
use app\models\FormComprobanteEgresoTipoCuentaNuevo;
use app\models\FormComprobanteEgresoTipoDetalleEditar;
use yii\helpers\ArrayHelper;

/**
 * ComprobanteEgresoTipoController implements the CRUD actions for ComprobanteEgresoTipo model.
 */
class ComprobanteEgresoTipoController extends Controller
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
     * Lists all ComprobanteEgresoTipo models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',26])->all()){
                $searchModel = new ComprobanteEgresoTipoSearch();
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
     * Displays a single ComprobanteEgresoTipo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modeldetalles = ComprobanteEgresoTipoCuenta::find()->Where(['=', 'id_comprobante_egreso_tipo', $id])->all();
        $registros = count($modeldetalles);
        if (Yii::$app->request->post()) {
            if (isset($_POST["eliminar"])) {
                if (isset($_POST["id_comprobante_egreso_tipo_cuenta"])) {
                    foreach ($_POST["id_comprobante_egreso_tipo_cuenta"] as $intCodigo) {
                        try {
                            $eliminar = ComprobanteEgresoTipoCuenta::findOne($intCodigo);
                            $eliminar->delete();
                            Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
                            $this->redirect(["comprobante-egreso-tipo/view", 'id' => $id]);
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
                    $this->redirect(["facturaventatipo/view", 'id' => $id]);
                   }
        }        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modeldetalles' => $modeldetalles,
            'registros' => $registros,
        ]);
    }

    /**
     * Creates a new ComprobanteEgresoTipo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComprobanteEgresoTipo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ComprobanteEgresoTipo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing ComprobanteEgresoTipo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
            $this->redirect(["comprobante-egreso-tipo/index"]);
        } catch (IntegrityException $e) {
            $this->redirect(["comprobante-egreso-tipo/index"]);
            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el registro, tiene registros asociados en otros procesos');
        } catch (\Exception $e) {            
            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el registro, tiene registros asociados en otros procesos');
            $this->redirect(["comprobante-egreso-tipo/index"]);
        }
    }
    
    public function actionNuevodetalles($id_comprobante_egreso_tipo)
    {
        $model = new FormComprobanteEgresoTipoCuentaNuevo();
        $cuentas = CuentaPub::find()->all();         
        if ($model->load(Yii::$app->request->post())) {
            $cuenta = CuentaPub::find()->where(['=','codigo_cuenta',$model->cuenta])->one();
            if ($cuenta){
                $table = new ComprobanteEgresoTipoCuenta;
                $table->id_comprobante_egreso_tipo = $id_comprobante_egreso_tipo;
                $table->cuenta = $model->cuenta;
                $table->tipocuenta = $model->tipocuenta;
                $table->base = $model->base;
                $table->subtotal = $model->subtotal;
                $table->iva = $model->iva;
                $table->rete_fuente = $model->rete_fuente;
                $table->rete_iva = $model->rete_iva;
                $table->total = $model->total;
                $table->base_rete_fuente = $model->base_rete_fuente;
                $table->porcentaje_base = $model->porcentaje_base;               
                $table->save(false);
                $this->redirect(["comprobante-egreso-tipo/view", 'id' => $id_comprobante_egreso_tipo]);
            }else{                
                Yii::$app->getSession()->setFlash('error', 'No exite la cuenta que desea ingresar, verificar en las cuentas del PUB!');
            }
            
        }

        return $this->render('_formnuevodetalles', [
            'model' => $model,
            'cuentas' => ArrayHelper::map($cuentas, "codigo_cuenta", "cuentanombre"),
            'id' => $id_comprobante_egreso_tipo
        ]);
    }
    
    public function actionEditardetalle($id_comprobante_egreso_tipo_cuenta) {
        $model = new FormComprobanteEgresoTipoDetalleEditar;
        $cuentas = CuentaPub::find()->all();        
        $comprobanteegresotipocuenta = ComprobanteEgresoTipoCuenta::findOne($id_comprobante_egreso_tipo_cuenta);
        
        if ($model->load(Yii::$app->request->post())) {                        
            $comprobanteegresotipocuenta->cuenta = $model->cuenta;
            $comprobanteegresotipocuenta->tipocuenta = $model->tipocuenta;
            $comprobanteegresotipocuenta->base = $model->base;
            $comprobanteegresotipocuenta->base = $model->base;
            $comprobanteegresotipocuenta->subtotal = $model->subtotal;
            $comprobanteegresotipocuenta->iva = $model->iva;
            $comprobanteegresotipocuenta->rete_fuente = $model->rete_fuente;
            $comprobanteegresotipocuenta->rete_iva = $model->rete_iva;
            $comprobanteegresotipocuenta->total = $model->total;
            $comprobanteegresotipocuenta->base_rete_fuente = $model->base_rete_fuente;
            $comprobanteegresotipocuenta->porcentaje_base = $model->porcentaje_base;
            $comprobanteegresotipocuenta->save(false);                                      
            return $this->redirect(['comprobante-egreso-tipo/view','id' => $comprobanteegresotipocuenta->id_comprobante_egreso_tipo]);
        }
        if (Yii::$app->request->get("id_comprobante_egreso_tipo_cuenta")) {
            $table = ComprobanteEgresoTipoCuenta::find()->where(['id_comprobante_egreso_tipo_cuenta' => $id_comprobante_egreso_tipo_cuenta])->one();
            if ($table) {
                $model->cuenta = $table->cuenta;
                $model->tipocuenta = $table->tipocuenta;
                $model->base = $table->base;
                $model->subtotal = $table->subtotal;
                $model->iva = $table->iva;
                $model->rete_fuente = $table->rete_fuente;
                $model->rete_iva = $table->rete_iva;
                $model->total = $table->total;
                $model->base_rete_fuente = $table->base_rete_fuente;
                $model->porcentaje_base = $table->porcentaje_base;
            }    
        }
        return $this->render('_formeditardetalle', [
            'model' => $model,
            'comprobanteegresotipocuenta' => $comprobanteegresotipocuenta,
            'cuentas' => ArrayHelper::map($cuentas, "codigo_cuenta", "cuentanombre"),
        ]);        
    }

    /**
     * Finds the ComprobanteEgresoTipo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComprobanteEgresoTipo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComprobanteEgresoTipo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
