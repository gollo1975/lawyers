<?php

namespace app\controllers;

use Yii;
use app\models\Conceptonota;
use app\models\ConceptonotaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UsuarioDetalle;
use app\models\Conceptonotacuenta;
use app\models\FormConceptoNotaCuentaNuevo;
use app\models\FormConceptoNotaDetalleEditar;
use app\models\CuentaPub;
use yii\helpers\ArrayHelper;

/**
 * ConceptonotaController implements the CRUD actions for Conceptonota model.
 */
class ConceptonotaController extends Controller
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
     * Lists all Conceptonota models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',8])->all()){
                $searchModel = new ConceptonotaSearch();
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
     * Displays a single Conceptonota model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modeldetalles = Conceptonotacuenta::find()->Where(['=', 'idconceptonota', $id])->all();
        $registros = count($modeldetalles);
        if (Yii::$app->request->post()) {
            if (isset($_POST["eliminar"])) {
                if (isset($_POST["idconceptonotacuenta"])) {
                    foreach ($_POST["idconceptonotacuenta"] as $intCodigo) {
                        try {
                            $eliminar = Conceptonotacuenta::findOne($intCodigo);
                            $eliminar->delete();
                            Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
                            $this->redirect(["conceptonota/view", 'id' => $id]);
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
                    $this->redirect(["conceptonota/view", 'id' => $id]);
                   }
        }        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modeldetalles' => $modeldetalles,
            'registros' => $registros,
        ]);
    }

    /**
     * Creates a new Conceptonota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Conceptonota();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Conceptonota model.
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
     * Deletes an existing Conceptonota model.
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
            $this->redirect(["conceptonota/index"]);
        } catch (IntegrityException $e) {
            $this->redirect(["conceptonota/index"]);
            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el concepto, tiene registros asociados en otros procesos');
        } catch (\Exception $e) {            
            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el concepto, tiene registros asociados en otros procesos');
            $this->redirect(["conceptonota/index"]);
        }
    }
    
    public function actionNuevodetalles($idconceptonota)
    {
        $model = new FormConceptoNotaCuentaNuevo();
        $cuentas = CuentaPub::find()->all();         
        if ($model->load(Yii::$app->request->post())) {
            $cuenta = CuentaPub::find()->where(['=','codigo_cuenta',$model->cuenta])->one();
            if ($cuenta){
                $table = new Conceptonotacuenta;
                $table->idconceptonota = $idconceptonota;
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
                $this->redirect(["conceptonota/view", 'id' => $idconceptonota]);
            }else{                
                Yii::$app->getSession()->setFlash('error', 'No exite la cuenta que desea ingresar, verificar en las cuentas del PUB!');
            }
            
        }

        return $this->render('_formnuevodetalles', [
            'model' => $model,
            'cuentas' => ArrayHelper::map($cuentas, "codigo_cuenta", "cuentanombre"),
            'id' => $idconceptonota
        ]);
    }
    
    public function actionEditardetalle($idconceptonotacuenta) {
        $model = new FormConceptoNotaDetalleEditar;
        $cuentas = CuentaPub::find()->all();        
        $conceptonotacuenta = Conceptonotacuenta::findOne($idconceptonotacuenta);
        
        if ($model->load(Yii::$app->request->post())) {                        
            $conceptonotacuenta->cuenta = $model->cuenta;
            $conceptonotacuenta->tipocuenta = $model->tipocuenta;
            $conceptonotacuenta->base = $model->base;
            $conceptonotacuenta->subtotal = $model->subtotal;
            $conceptonotacuenta->iva = $model->iva;
            $conceptonotacuenta->rete_fuente = $model->rete_fuente;
            $conceptonotacuenta->rete_iva = $model->rete_iva;
            $conceptonotacuenta->total = $model->total;
            $conceptonotacuenta->base_rete_fuente = $model->base_rete_fuente;
            $conceptonotacuenta->porcentaje_base = $model->porcentaje_base;
            $conceptonotacuenta->save(false);                                      
            return $this->redirect(['conceptonota/view','id' => $conceptonotacuenta->idconceptonota]);
        }
        if (Yii::$app->request->get("idconceptonotacuenta")) {
            $table = Conceptonotacuenta::find()->where(['idconceptonotacuenta' => $idconceptonotacuenta])->one();
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
            'conceptonotacuenta' => $conceptonotacuenta,
            'cuentas' => ArrayHelper::map($cuentas, "codigo_cuenta", "codigo_cuenta"),
        ]);        
    }

    /**
     * Finds the Conceptonota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conceptonota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conceptonota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
