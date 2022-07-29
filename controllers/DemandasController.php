<?php

namespace app\controllers;
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
use yii\db\Expression;
use yii\db\Query;

//modelos
use app\models\Demandas;
use app\models\DemandasSearch;
use app\models\UsuarioDetalle;
use app\models\FormFiltroDemandas;
use app\models\Actuaciones;
use app\models\TipoActuacion;
/**
 * DemandasController implements the CRUD actions for Demandas model.
 */
class DemandasController extends Controller
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
     * Lists all Demandas models.
     * @return mixed
     */
   public function actionIndex() {
        if (Yii::$app->user->identity){
        if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',13])->all()){
            $form = new FormFiltroDemandas();
            $idcliente = null;
            $id_especialidad = null;
            $documento = null;
            $documento_demandado = null;
            $id_clase_demanda = null;
            $codigo_juzgado = null;
            $desde = null;
            $hasta = null;
            $nro_demanda = null;
            if ($form->load(Yii::$app->request->get())) {
                if ($form->validate()) {
                    $idcliente = Html::encode($form->idcliente);
                    $id_especialidad = Html::encode($form->id_especialidad);
                    $documento_demandado = Html::encode($form->documento_demandado);
                    $documento = Html::encode($form->documento);
                    $id_clase_demanda = Html::encode($form->id_clase_demanda);;
                    $codigo_juzgado = Html::encode($form->codigo_juzgado);
                    $desde = Html::encode($form->desde);
                    $hasta = Html::encode($form->hasta);
                    $nro_demanda = Html::encode($form->nro_demanda);
                    $table = Demandas::find()
                            ->andFilterWhere(['=', 'idcliente', $idcliente])
                            ->andFilterWhere(['=', 'id_especialidad', $id_especialidad])
                            ->andFilterWhere(['=', 'documento', $documento])
                            ->andFilterWhere(['=', 'documento_demandado', $documento_demandado])
                            ->andFilterWhere(['=', 'id_clase_demanda', $id_clase_demanda])
                            ->andFilterWhere(['=', 'codigo_juzgado', $codigo_juzgado])
                            ->andFilterWhere(['>=', 'fecha_presentacion', $desde])
                            ->andFilterWhere(['<=', 'fecha_presentacion', $hasta])
                            ->andFilterWhere(['=', 'nro_demanda', $nro_demanda]);
                    $table = $table->orderBy('nro_demanda desc');
                    $tableexcel = $table->all();
                    $count = clone $table;
                    $to = $count->count();
                    $pages = new Pagination([
                        'pageSize' => 40,
                        'totalCount' => $count->count()
                    ]);
                    $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                    if(isset($_POST['excel'])){
                        //$table = $table->all();
                        $this->actionExcelconsultaDemandas($tableexcel);
                    }
                } else {
                    $form->getErrors();
                }
            } else {
                $table = Demandas::find()
                        ->orderBy('nro_demanda desc');
                $tableexcel = $table->all();
                $count = clone $table;
                $pages = new Pagination([
                    'pageSize' => 40,
                    'totalCount' => $count->count(),
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                if(isset($_POST['excel'])){
                    //$table = $table->all();
                    $this->actionExcelconsultaDemandas($tableexcel);
                }
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
     * Displays a single Demandas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $actuacion = \app\models\Actuaciones::find()->where(['=','nro_demanda', $id])->all();
        $servicio = \app\models\ServicioPrestado::find()->where(['=','nro_demanda', $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'actuacion' => $actuacion,
            'servicio' => $servicio,
        ]);
    }

    /**
     * Creates a new Demandas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Demandas();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())){
            if($model->validate()){
                $nombre = \app\models\ClasesDemandas::find()->where(['id_clase_demanda' =>$model->id_clase_demanda])->one();
                $table = new Demandas();
                $table->idcliente = $model->idcliente;
                $table->codigo_juzgado = $model->codigo_juzgado;
                $table->id_clase_demanda = $model->id_clase_demanda;
                $table->clase = $nombre->concepto;
                $table->id_especialidad = $model->id_especialidad;
                $table->documento = $model->documento;
                $table->documento_demandado = $model->documento_demandado;
                $table->numero_hojas = $model->numero_hojas;
                $table->fecha_presentacion = $model->fecha_presentacion;
                $table->fecha_registro = date('Y-m-d');
                $table->usuario = Yii::$app->user->identity->username;
                $table->observacion = $model->observacion;
                $table->save(false);
                return $this->redirect(['index']);
            }else{
                $model->getErrors();
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Demandas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $table = Demandas::findOne($id);
                $nombre = \app\models\ClasesDemandas::find()->where(['id_clase_demanda' =>$model->id_clase_demanda])->one();
                if($table){
                    $table->idcliente = $model->idcliente;
                    $table->codigo_juzgado = $model->codigo_juzgado;
                    $table->id_clase_demanda = $model->id_clase_demanda;
                    $table->clase =  $nombre->concepto;
                    $table->id_especialidad = $model->id_especialidad;
                    $table->documento = $model->documento;
                    $table->documento_demandado = $model->documento_demandado;
                    $table->numero_hojas = $model->numero_hojas;
                    $table->fecha_presentacion = $model->fecha_presentacion;
                    $table->observacion = $model->observacion;
                    $table->save();
                   return $this->redirect(['index']);
                }
            }else{
                $model->getErrors();
            }    
        }
        if (Yii::$app->request->get("id")) {
            $table = Demandas::find()->where(['nro_demanda' => $id])->one();
            $model->idcliente = $table->idcliente;
            $model->codigo_juzgado = $table->codigo_juzgado;
            $model->id_clase_demanda = $table->id_clase_demanda;
            $model->id_especialidad = $table->id_especialidad;
            $model->documento = $table->documento;
            $model->documento_demandado = $table->documento_demandado;
            $model->numero_hojas = $table->numero_hojas;
            $model->fecha_presentacion = $table->fecha_presentacion;
            $model->observacion = $table->observacion;
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

   //CREAR NOTIFICACION
   public function actionNueva_notificacion($id) {
        $model = new \app\models\Actuaciones();
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {           
            $table = new Actuaciones();
            $table->id_tipo = $model->id_tipo;
            $table->fecha_actuacion = $model->fecha_actuacion;
            $table->nro_demanda = $id;
            $table->fecha_inicio = $model->fecha_inicio;
            $table->fecha_finaliza = $model->fecha_finaliza;
            $table->usuario = Yii::$app->user->identity->username;
            $table->anotacion = $model->anotacion;
            $table->insert();
            return $this->redirect(['view','id' => $id]);
        } 
         return $this->render('crear_notificacion', [
            'model' => $model,
            'id' => $id,
         
        ]);
       
   }
   
   // PERMITE CREAR LOS SERVICIOS PARA FACTURAR 
    public function actionCrear_servicios($id) {
        $model = new \app\models\ServicioPrestado();
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {           
            $table = new \app\models\ServicioPrestado();
            $table->nro_demanda = $id;
            $table->id_factura_venta_tipo = $model->id_factura_venta_tipo;
            $table->forma_pago = $model->forma_pago;
            $table->valor_pagar = $model->valor_pagar;
             $table->saldo_servicio = $model->valor_pagar;
            $table->usuario = Yii::$app->user->identity->username;
            $table->observacion = $model->observacion;
            $table->insert();
            return $this->redirect(['view','id' => $id]);
        } 
         return $this->render('crear_servicios', [
            'model' => $model,
            'id' => $id,
         
        ]);
       
   }
    public function actionEditar_servicio($id, $codigo) {
        $model = \app\models\ServicioPrestado::findOne($codigo);
        $detalle = \app\models\Facturaventadetalle::find()->where(['=','nro_demanda', $id])->andWhere(['=','id_factura_venta_tipo', $model->id_factura_venta_tipo])->one();
        if($detalle){
             return $this->redirect(['view','id' => $id]);
             Yii::$app->getSession()->setFlash('warning', 'El registro no se puede modificar porque ya esta en proceso de facturación.');
        }else{
            if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post())) {           
               $table = \app\models\ServicioPrestado::findOne($codigo);
                $table->id_factura_venta_tipo = $model->id_factura_venta_tipo;
                $table->forma_pago = $model->forma_pago;
                $table->valor_pagar = $model->valor_pagar;
                $table->observacion = $model->observacion;
                $table->save(false);
                return $this->redirect(['view','id' => $id]);
            } 
        }    
        if (Yii::$app->request->get("id, $codigo")) {
            $table = \app\models\ServicioPrestado::findOne($codigo);
            $model->id_factura_venta_tipo = $table->id_factura_venta_tipo;
            $model->forma_pago = $table->forma_pago;
            $model->valor_pagar = $table->valor_pagar;
            $model->observacion = $table->observacion;
        }
         return $this->render('editar', [
            'model' => $model,
            'id' => $id,
            'codigo' => $codigo, 
         
        ]);
       
   }
    
   //ESTE PROCESO PERMITE MODIFICAR LAS ACTUACIONES
   
    public function actionEditar_actuacion($id, $codigo) {
        $model = \app\models\Actuaciones::findOne($codigo);
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {           
           $table = \app\models\Actuaciones::findOne($codigo);
            $table->id_tipo = $model->id_tipo;
            $table->fecha_actuacion = $model->fecha_actuacion;
            $table->fecha_inicio = $model->fecha_inicio;
            $table->fecha_finaliza = $model->fecha_finaliza;
            $table->anotacion = $model->anotacion;
            $table->save(false);
            return $this->redirect(['view','id' => $id]);
        } 
        if (Yii::$app->request->get("id, $codigo")) {
            $table = \app\models\Actuaciones::findOne($codigo);
            $model->id_tipo = $table->id_tipo;
            $model->fecha_actuacion = $table->fecha_actuacion;
            $model->fecha_finaliza = $table->fecha_finaliza;
            $model->fecha_inicio = $table->fecha_inicio;
            $model->anotacion = $table->anotacion;
        }
         return $this->render('editar_actuacion', [
            'model' => $model,
            'id' => $id,
            'codigo' => $codigo, 
         
        ]);
       
   }
   //GENERAR RADICADO
   
   public function actionGeneraradicado ($id) {
        $model = new \app\models\FormRadicado();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()){
                $demanda = Demandas::find()->where(['=','nro_demanda', $id])->one(); 
               if (isset($_POST["radicado"])) { 
                    $demanda->radicado = $model->radicado;
                    $demanda->save(false);
                    $this->redirect(["index"]); 
                }
           } 
        }
        if (Yii::$app->request->get("id")) {
            $table = Demandas::find()->where(['nro_demanda' => $id])->one();            
            if ($table) {                                
                $model->nro_demanda = $table->nro_demanda;                
                $model->radicado = $table->radicado;                
            }
        }
        return $this->renderAjax('generaradicado', [
            'model' => $model,   
            'id' => $id,
        ]);    
    }
    /**
     * Deletes an existing Demandas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Demandas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Demandas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Demandas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
