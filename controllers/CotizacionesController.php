<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Response;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

//models
use app\models\Cotizaciones;
use app\models\UsuarioDetalle;
use app\models\CotizacionDetalle;


/**
 * CotizacionesController implements the CRUD actions for Cotizaciones model.
 */
class CotizacionesController extends Controller
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
     * Lists all Cotizaciones models.
     * @return mixed
     */
    public function actionIndex($token = 0) {
        if (Yii::$app->user->identity) {
            if (UsuarioDetalle::find()->where(['=', 'codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=', 'id_permiso',7])->all()) {
                $form = new \app\models\FiltroBusquedaCotizacion();
                $numero = null;
                $cliente = null;
                $fecha_inicio = null;
                $fecha_corte = null;
                if ($form->load(Yii::$app->request->get())) {
                    if ($form->validate()) {
                        $numero = Html::encode($form->numero);
                        $cliente = Html::encode($form->cliente);
                        $fecha_inicio = Html::encode($form->fecha_inicio);
                        $fecha_corte = Html::encode($form->fecha_corte);
                        $table = Cotizaciones::find()
                                ->andFilterWhere(['=', 'numero_cotizacion', $numero])
                                ->andFilterWhere(['=', 'id_cliente', $cliente])
                                ->andFilterWhere(['between', 'fecha_cotizacion', $fecha_inicio, $fecha_corte]);
                        $table = $table->orderBy('id_cotizacion DESC');
                        $tableexcel = $table->all();
                        $count = clone $table;
                        $to = $count->count();
                        $pages = new Pagination([
                            'pageSize' => 15,
                            'totalCount' => $count->count()
                        ]);
                        $modelo = $table
                                ->offset($pages->offset)
                                ->limit($pages->limit)
                                ->all();
                        if (isset($_POST['excel'])) {
                            $check = isset($_REQUEST['id_cotizacion DESC']);
                            $this->actionExcelconsultaCotizacion($tableexcel);
                        }
                    } else {
                        $form->getErrors();
                    }
                } else {
                    $table = Cotizaciones::find()
                             ->orderBy('id_cotizacion DESC');
                    $tableexcel = $table->all();
                    $count = clone $table;
                    $pages = new Pagination([
                        'pageSize' => 15,
                        'totalCount' => $count->count(),
                    ]);
                    $modelo = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                    if (isset($_POST['excel'])) {
                        //$table = $table->all();
                        $this->actionExcelconsultaCotizacion($tableexcel);
                    }
                }
                $to = $count->count();
                return $this->render('index', [
                            'modelo' => $modelo,
                            'form' => $form,
                            'pagination' => $pages,
                            'token' => $token,
                ]);
            } else {
                return $this->redirect(['site/sinpermiso']);
            }
        } else {
            return $this->redirect(['site/login']);
        }
    }
    
    //CONSULTA DE COTIZACIONES
    public function actionIndex_cotizaciones($token = 1) {
        if (Yii::$app->user->identity) {
            if (UsuarioDetalle::find()->where(['=', 'codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=', 'id_permiso',12])->all()) {
                $form = new \app\models\FiltroBusquedaCotizacion();
                $numero = null;
                $cliente = null;
                $fecha_inicio = null;
                $fecha_corte = null;
                if ($form->load(Yii::$app->request->get())) {
                    if ($form->validate()) {
                        $numero = Html::encode($form->numero);
                        $cliente = Html::encode($form->cliente);
                        $fecha_inicio = Html::encode($form->fecha_inicio);
                        $fecha_corte = Html::encode($form->fecha_corte);
                        $table = Cotizaciones::find()
                                ->andFilterWhere(['=', 'numero_cotizacion', $numero])
                                ->andFilterWhere(['=', 'id_cliente', $cliente])
                                ->andFilterWhere(['between', 'fecha_cotizacion', $fecha_inicio, $fecha_corte])
                                ->andwhere(['=','proceso_cerrado', 1]);
                        $table = $table->orderBy('id_cotizacion DESC');
                        $tableexcel = $table->all();
                        $count = clone $table;
                        $to = $count->count();
                        $pages = new Pagination([
                            'pageSize' => 15,
                            'totalCount' => $count->count()
                        ]);
                        $modelo = $table
                                ->offset($pages->offset)
                                ->limit($pages->limit)
                                ->all();
                        if (isset($_POST['excel'])) {
                            $check = isset($_REQUEST['id_cotizacion DESC']);
                            $this->actionExcelconsultaCotizacion($tableexcel);
                        }
                    } else {
                        $form->getErrors();
                    }
                } else {
                    $table = Cotizaciones::find()->where(['=','proceso_cerrado', 1])
                             ->orderBy('id_cotizacion DESC');
                    $tableexcel = $table->all();
                    $count = clone $table;
                    $pages = new Pagination([
                        'pageSize' => 15,
                        'totalCount' => $count->count(),
                    ]);
                    $modelo = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                    if (isset($_POST['excel'])) {
                        //$table = $table->all();
                        $this->actionExcelconsultaCotizacion($tableexcel);
                    }
                }
                $to = $count->count();
                return $this->render('index_cotizaciones', [
                            'modelo' => $modelo,
                            'form' => $form,
                            'pagination' => $pages,
                            'token' => $token,
                ]);
            } else {
                return $this->redirect(['site/sinpermiso']);
            }
        } else {
            return $this->redirect(['site/login']);
        }
    }

    //RENTABILIDAD X REFERENCIA
    public function actionSearch_rentabilidad() {
        if (Yii::$app->user->identity) {
            if (UsuarioDetalle::find()->where(['=', 'codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=', 'id_permiso',14])->all()) {
                $form = new \app\models\FiltroBusquedaCotizacion();
                $numero = null;
                $cliente = null;
                $fecha_inicio = null;
                $fecha_corte = null;
                $grupo = null;
                $referencia= null; $codigo = null;
                $modelo = null;
                $pages = null;
                if ($form->load(Yii::$app->request->get())) {
                    if ($form->validate()) {
                        $numero = Html::encode($form->numero);
                        $cliente = Html::encode($form->cliente);
                        $fecha_inicio = Html::encode($form->fecha_inicio);
                        $fecha_corte = Html::encode($form->fecha_corte);
                        $grupo = Html::encode($form->grupo);
                        $referencia = Html::encode($form->referencia);
                        $codigo = Html::encode($form->codigo);
                        $table = CotizacionDetalle::find()
                                ->andFilterWhere(['=', 'codigo', $codigo])
                                ->andFilterWhere(['like', 'referencia', $referencia])
                                ->andFilterWhere(['=', 'id_cotizacion', $numero])
                                ->andFilterWhere(['=', 'id_cotizacion', $cliente])
                                ->andFilterWhere(['=', 'id_grupo', $grupo])
                                ->andFilterWhere(['between', 'fecha_cotizacion', $fecha_inicio, $fecha_corte]);
                        $table = $table->orderBy('id_cotizacion DESC');
                        $tableexcel = $table->all();
                        $count = clone $table;
                        $to = $count->count();
                        $pages = new Pagination([
                            'pageSize' => 15,
                            'totalCount' => $count->count()
                        ]);
                        $modelo = $table
                                ->offset($pages->offset)
                                ->limit($pages->limit)
                                ->all();
                        if (isset($_POST['excel'])) {
                            $check = isset($_REQUEST['id_cotizacion DESC']);
                            $this->actionExcelconsultaRentabilidad($tableexcel);
                        }
                    } else {
                        $form->getErrors();
                    }
                } 
                return $this->render('search_rentabilidad', [
                            'modelo' => $modelo,
                            'form' => $form,
                            'pagination' => $pages,
                ]);
            } else {
                return $this->redirect(['site/sinpermiso']);
            }
        } else {
            return $this->redirect(['site/login']);
        }
    }
    
    /**
     * Displays a single Cotizaciones model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $token)
    {
        $referencias = \app\models\CotizacionDetalle::find()->where(['=','id_cotizacion', $id])->all();
        $model = Cotizaciones::findOne($id);
        //actualiza los regisgtros de las referencias
        if (isset($_POST["actualizar_linea"])) {
            $intIndice = 0;
            $variable = 0; $unidades = 0;
            foreach ($_POST["listado_referencia"] as $intCodigo) {
                $variable = $_POST["tipo_lista"][$intIndice];
                $BuscarLista = \app\models\ReferenciaListaPrecio::findOne($variable);
                $table = \app\models\CotizacionDetalle::findOne($intCodigo);
                $table->id_detalle = $_POST["tipo_lista"][$intIndice];
                $table->valor_unidad = $BuscarLista->valor_venta;
                $table->save(false);
                if($table->cantidad_referencia > 0){
                    $id_referencia = $intCodigo;
                    $this->ContarCantidadTalla($id_referencia);
                }
                $intIndice++;
            } 
             return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]);
        } 
        //ELIMINA LAS REFERENCIAS CREADAS EN LAS VISTA
        if (Yii::$app->request->post()) {
            if (isset($_POST["eliminar_referencia"])) {
                if (isset($_POST["listado_eliminar"])) {
                    foreach ($_POST["listado_eliminar"] as $intCodigo) {
                        try {
                            $eliminar = \app\models\CotizacionDetalle::findOne($intCodigo);
                            $eliminar->delete();
                            Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
                            $this->redirect(["cotizaciones/view", 'id' => $id, 'token' => $token]);
                        } catch (IntegrityException $e) {
                          
                            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el detalle, tiene registros asociados en otros procesos');
                        } catch (\Exception $e) {
                            Yii::$app->getSession()->setFlash('error', 'Error al eliminar el detalle, tiene registros asociados en otros procesos');

                        }
                    }
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Debe seleccionar al menos un registro.');
                }    
             }
        }    
        
        return $this->render('view', [
            'model' => $model,
            'referencias' => $referencias,
             'token' => $token,
        ]);
    }
    
    //PERMITE VER LAS TALLAS DE LA REFERENCIA
    public function actionVer_tallas($id, $id_referencia , $token) {
        $tallas_referencia = \app\models\CotizacionDetalleTalla::find()->where(['=','id', $id_referencia])->all();
        $model = \app\models\CotizacionDetalle::findOne($id_referencia);
        if (isset($_POST["actualizar_cantidades"])) {
            $intIndice = 0;
            $contar = 0;
            foreach ($_POST["listado_tallas"] as $intCodigo) {
                $contar = $_POST["cantidad"][$intIndice];    
                if($contar > 0){
                    $table = \app\models\CotizacionDetalleTalla::findOne($intCodigo);
                    $table->cantidad = $_POST["cantidad"][$intIndice];
                    $table->save();
                    $intIndice++;
                }else{
                    $intIndice++;
                }  
            }
             $this->ContarCantidadTalla($id_referencia);
             return $this->redirect(['cotizaciones/ver_tallas', 'id' => $id,'id_referencia' => $id_referencia, 'token' => $token]);
        }    
         return $this->render('ver_tallas', [
            'id' => $id,
            'tallas_referencia' => $tallas_referencia,
            'model' => $model,
            'id_referencia' => $id_referencia,
             'token' => $token,
        ]);
    }
    
    // PROCESO QUE CUENTA LAS CANTIDADES VENDIDAS POR TALLAS
    protected function ContarCantidadTalla($id_referencia) {
        $referencia = \app\models\CotizacionDetalle::findOne($id_referencia);
        $tallas = \app\models\CotizacionDetalleTalla::find()->where(['=','id', $id_referencia])->all();
        $sumar = 0;
        foreach ($tallas as $talla):
            $sumar += $talla->cantidad;
        endforeach;
        $referencia->cantidad_referencia = $sumar;
        $referencia->save(false);
       $this->CalcularValoresReferencia($id_referencia);
        
    }
    
    //PROCESO QUE CALCULA EL TOTAL POR REFEENCIA
    protected function CalcularValoresReferencia($id_referencia) {
       $referencia = \app\models\CotizacionDetalle::findOne($id_referencia);
       $empresa = \app\models\Matriculaempresa::findOne(1);
       $iva = 0; $subtotal = 0;
       $subtotal = $referencia->valor_unidad * $referencia->cantidad_referencia;
       $iva = round(($subtotal * $empresa->porcentaje_iva)/100);
       $total = $subtotal + $iva;
       $referencia->subtotal = $subtotal;
       $referencia->impuesto = $iva;
       $referencia->total_linea = $total;
       $referencia->save(false);
    }
   
    //PROCESO QUE ELIMINA UN TALLA DEL LISTADO DE TALLAS
    public function actionEliminar_lineas($id_talla, $id_referencia, $id, $token)
    {
        $dato = \app\models\CotizacionDetalleTalla::findOne($id_talla);
        $dato->delete();
        $this->ContarCantidadTalla($id_referencia);
       return $this->redirect(['cotizaciones/ver_tallas', 'id' => $id,'id_referencia' => $id_referencia, 'token' => $token]);
    }
    
    

    /**
     * Creates a new Cotizaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cotizaciones();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->fecha_cotizacion = date('Y-m-d');
            $model->user_name = Yii::$app->user->identity->username;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cotizaciones model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cotizaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   //PROCESO QUE AUTORIZA EL PRODUCTO
    public function actionAutorizado($id, $token) {
        $pedido = Cotizaciones::findOne($id);
        $referencias = \app\models\CotizacionDetalle::find()->where(['=','id_cotizacion', $id])->one();
        $sw = 0;
        $sw1 = 0;
        if($referencias){
           $referencia = \app\models\CotizacionDetalle::find()->where(['=','id_cotizacion', $id])->all();
           foreach ($referencia as $refe):
               if($refe->valor_unidad == 0 ){
                   $sw = 1;
               }
           endforeach;
           if($sw == 0){
               if($pedido->tipo_cotizacion == 0){
                    if($pedido->autorizado == 0){
                        $pedido->autorizado = 1;
                        $pedido->save();
                    }else{
                        $pedido->autorizado = 0;
                        $pedido->save();
                    } 
                    return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]);
               }else{
                    $tallas = \app\models\CotizacionDetalleTalla::find()->where(['=','id_cotizacion', $id])->all();
                    if(count($tallas) > 0){
                        foreach ($tallas as $talla):
                            if($talla->cantidad  == 0){
                                $sw1 = 1;
                            }
                        endforeach;
                        if($sw1 == 0){
                             if($pedido->autorizado == 0){
                                 $pedido->autorizado = 1;
                                 $pedido->save();
                             }else{
                                 $pedido->autorizado = 0;
                                 $pedido->save();
                             } 
                             return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]);
                        }else{
                            Yii::$app->getSession()->setFlash('error','Favor ingresar las tallas y las cantidades de cada referencia para autorizar la cotización. ');
                              return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]);
                        }
                    }else{
                       Yii::$app->getSession()->setFlash('warning','Favor ingresar las tallas a cada referencia para autorizar la cotizacion. ');
                       return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]);  
                    }
                }    
               
           }else{
                Yii::$app->getSession()->setFlash('warning','Selecciona las listas de precio y presiona ACTUALIZAR. Luego debe de ingresar las tallas de cada referencias. ');
                return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]);   
           }
        }else{
            Yii::$app->getSession()->setFlash('error', 'No hay REFERENCIAS asignadas a la cotizacion del cliente ('.$pedido->cliente->nombrecorto. ').');
            return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]); 
        }
    }
    
    //PROCESO QUE CIERRA EL PEDIDO
    public function actionCerrar_pedido($id, $token) {
        $model = Cotizaciones::findOne($id);
         //generar consecutivo
        $registro = \app\models\Consecutivo::findOne(2);
        $valor = $registro->consecutivo + 1;
        $model->numero_cotizacion = $valor;
        $model->proceso_cerrado = 1;
        $model->save();
        //actualiza consecutivo
        $registro->consecutivo = $valor;
        $registro->save();
        $this->CalcularTotalPedido($id);
        return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]); 
    }
    
    //PROCESO QUE TOTALIZA Y CALCULA LOS VALORES DE CADA REFERENCIA
    protected function CalcularTotalPedido($id) {
        $model = Cotizaciones::findOne($id);
        $referencia = \app\models\CotizacionDetalle::find()->where(['=','id_cotizacion', $id])->all();
        $cantidad= 0; $subtotal = 0; $iva = 0; $total = 0;
        foreach ($referencia as $referencias):
            $cantidad += $referencias->cantidad_referencia;
            $subtotal += $referencias->subtotal;
            $iva += $referencias->impuesto;
            $total += $referencias->total_linea;
        endforeach;
        $model->total_prendas = $cantidad;
        $model->subtotal = $subtotal;
        $model->impuesto = $iva;
        $model->total_cotizacion = $total;
        $model->save();
    }
    
    
    //ACTUALIZAR SALDOS
     public function actionActualizar_saldos($id, $token) {
        $this->CalcularTotalPedido($id);
        return $this->redirect(['cotizaciones/view', 'id' => $id, 'token' => $token]);   
     }
    
     //BUSCA INSUMOS PARA AGREGAR AL SIMULADOR
    public function actionCargar_nueva_referencia($id, $token){
        $operacion = \app\models\ReferenciaProducto::find()->where(['>','costo_producto', 0])->orderBy('descripcion_referencia ASC')->all();
        $form = new \app\models\ModeloBuscar();
        $referencia = null;
        $clasificacion = null;
        $detalle = CotizacionDetalle::find()->where(['=','id_cotizacion', $id])->all();
        if(count($detalle) <> 8){
            if ($form->load(Yii::$app->request->get())) {
                if ($form->validate()) {
                    $referencia = Html::encode($form->referencia);  
                    $clasificacion = Html::encode($form->clasificacion); 
                    $operacion = \app\models\ReferenciaProducto::find()
                            ->andFilterWhere(['like','descripcion_referencia', $referencia])
                            ->andFilterWhere(['=','id_grupo', $clasificacion]);
                    $operacion = $operacion->orderBy('descripcion_referencia ASC');                    
                    $count = clone $operacion;
                    $to = $count->count();
                    $pages = new Pagination([
                        'pageSize' => 8,
                        'totalCount' => $count->count()
                    ]);
                    $operacion = $operacion
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();         
                } else {
                    $form->getErrors();
                }                    
            }else{
                $operacion = \app\models\ReferenciaProducto::find()->where(['>','costo_producto', 0])->orderBy('descripcion_referencia ASC');
                $tableexcel = $operacion->all();
                $count = clone $operacion;
                $pages = new Pagination([
                            'pageSize' => 8,
                            'totalCount' => $count->count(),
                ]);
                 $operacion = $operacion
                                ->offset($pages->offset)
                                ->limit($pages->limit)
                                ->all();
            }
            //PROCESO DE GUARDAR
             if (isset($_POST["enviar_referencias"])) {
                if(isset($_POST["codigo_referencia"])){
                    $intIndice = 0;
                    foreach ($_POST["codigo_referencia"] as $intCodigo) {
                        ///VALIDA QUE NO HAYA REGISTRO DUPLICADOS
                        $registro = \app\models\CotizacionDetalle::find()->where(['=','codigo', $intCodigo])->andWhere(['=','id_cotizacion', $id])->one();
                        if(!$registro){
                            $item = \app\models\ReferenciaProducto::findOne($intCodigo);
                            $table = new \app\models\CotizacionDetalle();
                            $table->id_cotizacion = $id;
                            $table->codigo = $intCodigo;
                            $table->referencia = $item->descripcion_referencia;
                            $table->user_name = Yii::$app->user->identity->username;
                            $table->id_grupo = $item->id_grupo;
                            $table->nota_comercial = $item->nota_comercial;
                            $table->fecha_cotizacion = date('Y-m-d');
                            $table->save(false);
                        }    
                    }
                    return $this->redirect(['view','id' => $id, 'token' => $token]);
                }
            }
            return $this->render('importar_referencias', [
                'operacion' => $operacion,            
                'pagination' => $pages,
                'id' => $id,
                'form' => $form,
                'token' => $token,

            ]);
        }else{
            Yii::$app->getSession()->setFlash('warning','Solo se pueden crea OCHO (8) referencias en una misma cotizacion. Favor hacer otra cotizacion. ');
            return $this->redirect(['view','id' => $id, 'token' => $token]); 
        }    
    }
    
    //CREAR TALLAS
     public function actionCrear_tallas_referencia($id, $id_referencia, $token){
        $tallas = \app\models\Tallas::find()->orderBy('id_talla ASC')->all();
        $form = new \app\models\ModeloBuscar();
        $q = null;
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $q = Html::encode($form->q);                                
                if ($q){
                    $tallas = \app\models\Tallas::find()
                            ->where(['like','nombre_talla',$q])
                            ->orderBy('id_talla ASC')
                            ->all();
                }               
            } else {
                $form->getErrors();
            }                    
                    
        } else {
             $tallas = \app\models\Tallas::find()->orderBy('id_talla ASC')->all();
        }
        if (isset($_POST["listado_tallas"])) {
                $intIndice = 0;
                foreach ($_POST["listado_tallas"] as $intCodigo) {
                   
                    $talla = \app\models\Tallas::find()->where(['id_talla' => $intCodigo])->one();
                    $detalles = \app\models\CotizacionDetalleTalla::find()
                        ->where(['=', 'id', $id])
                        ->andWhere(['=', 'id_talla', $talla->id_talla])
                        ->all();
                    $reg = count($detalles);
                    if ($reg == 0) {
                        $table = new \app\models\CotizacionDetalleTalla();
                        $table->id_talla = $intCodigo;
                        $table->id = $id_referencia;
                        $table->id_cotizacion = $id;
                        $table->cantidad = 0;
                        $table->user_name = Yii::$app->user->identity->username;
                        $table->save(false); 
                    }
                }
                $this->redirect(["cotizaciones/view", 'id' => $id, 'token' => $token]);
        }
        return $this->render('crear_tallas', [
            'tallas' => $tallas,            
            'id' => $id,
            'form' => $form,
            'id_referencia' => $id_referencia,
            'token' => $token,
        ]);
    
    }
    
     //modificar cantidades produccion
    public function actionSubir_nota($id, $id_referencia, $token) {
        $model = new \app\models\ModeloBuscar();
        $table = \app\models\CotizacionDetalle::findOne($id_referencia);
        $cotizacion = Cotizaciones::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST["grabar_nota"])) { 
                $table->nota = $model->nota;
                $table->cantidad_referencia = $model->cantidad;
                $table->save(false);
                $this->CalcularValoresReferencia($id_referencia);
               return $this->redirect(["cotizaciones/view", 'id' => $id, 'token' => $token]);
            }    
        }
         if (Yii::$app->request->get()) {
            $model->nota = $table->nota; 
            $model->cantidad = $table->cantidad_referencia; 
         }
        return $this->renderAjax('nota_referencia', [
            'model' => $model,
            'id_referencia' => $id_referencia,
            'id' => $id,
            'tipo_cotizacion' => $cotizacion->tipo_cotizacion,
        ]);
    }
    
    //PERMITE IMPRIMIR
    public function actionImprimir_cotizacion($id)
    {
        $empresa = \app\models\Matriculaempresa::findOne(1);
        if($empresa->tipo_formato == 0){
             return $this->render('../reportes/reporte_cotizacion_cliente', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->render('../reportes/reporte_cotizacion_cliente_detalle', [
               'model' => $this->findModel($id),
          
            ]); 
        }
       
    }
    
    public function actionImprimir_tallas($id)
    {
        return $this->render('../reportes/reporte_cotizacion_tallas', [
            'model' => $this->findModel($id),
            
        ]);
    }
    
    /**
     * Finds the Cotizaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cotizaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cotizaciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       //EXPORTA EXCEL GENERAL
    
     public function actionExcelconsultaCotizacion($tableexcel) {   
        $objPHPExcel = new \PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("EMPRESA")
            ->setLastModifiedBy("EMPRESA")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);

        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Nº COTIZACION')
                    ->setCellValue('C1', 'DOCUMENTO')
                    ->setCellValue('D1', 'CLIENTE')
                    ->setCellValue('E1', 'FECHA COTIZACION')
                    ->setCellValue('F1', 'FECHA ENTREGA')
                    ->setCellValue('G1', 'TOTAL UNIDADES')
                    ->setCellValue('H1', 'SUBTOTAL')
                    ->setCellValue('I1', 'IMPUESTO')
                    ->setCellValue('J1', 'TOTAL')
                    ->setCellValue('K1', 'CERRADO')
                    ->setCellValue('L1', 'USER NAME')
                    ->setCellValue('M1', 'CODIGO')
                    ->setCellValue('N1', 'REFERENCIA')
                    ->setCellValue('O1', 'VR UNITARIO')
                    ->setCellValue('P1', 'VR COSTO')
                    ->setCellValue('Q1', 'CANTIDAD')
                    ->setCellValue('R1', 'SUBTOTA')
                    ->setCellValue('S1', 'IVA')
                    ->setCellValue('T1', 'TOTAL LINEA')
                     ->setCellValue('U1', 'OBSERVACION');
        $i = 2;
        
        foreach ($tableexcel as $val) {
            $referencias  = \app\models\CotizacionDetalle::find()->where(['=','id_cotizacion', $val->id_cotizacion])->all();
            foreach ($referencias as $referencia){
                                  
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $val->id_cotizacion)
                        ->setCellValue('B' . $i, $val->numero_cotizacion)
                        ->setCellValue('C' . $i, $val->cliente->cedulanit)
                        ->setCellValue('D' . $i, $val->cliente->nombrecorto)
                        ->setCellValue('E' . $i, $val->fecha_cotizacion)
                        ->setCellValue('F' . $i, $val->fecha_entrega)
                        ->setCellValue('G' . $i, $val->total_prendas)
                        ->setCellValue('H' . $i, $val->subtotal)
                        ->setCellValue('I' . $i, $val->impuesto)
                        ->setCellValue('J' . $i, $val->total_cotizacion)
                        ->setCellValue('K' . $i, $val->procesoCerrado)
                        ->setCellValue('L' . $i, $val->user_name)
                        ->setCellValue('M' . $i, $referencia->codigo)
                        ->setCellValue('N' . $i, $referencia->referencia)
                        ->setCellValue('O' . $i, $referencia->valor_unidad)
                        ->setCellValue('P' . $i, $referencia->codigoReferencia->costo_producto)
                        ->setCellValue('Q' . $i, $referencia->cantidad_referencia)
                        ->setCellValue('R' . $i, $referencia->subtotal)
                        ->setCellValue('S' . $i, $referencia->impuesto)
                        ->setCellValue('T' . $i, $referencia->total_linea)
                        ->setCellValue('U' . $i, $referencia->nota);;
                $i++;
            }
            $i = $i;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Listado');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Cotizacion_cliente.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
        exit;
    }
    
    //EXCEL TALLAS
    public function actionExcel_tallas($id, $id_referencia) {   
        $talla = \app\models\CotizacionDetalleTalla::find()->where(['=','id_cotizacion', $id])
                                                           ->andWhere(['=','id', $id_referencia])->all();
        $objPHPExcel = new \PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("EMPRESA")
            ->setLastModifiedBy("EMPRESA")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
       

        $objPHPExcel->setActiveSheetIndex(0)
                    
                    ->setCellValue('B1', 'Nº COTIZACION')
                    ->setCellValue('C1', 'DOCUMENTO')
                    ->setCellValue('D1', 'CLIENTE')
                    ->setCellValue('E1', 'FECHA COTIZACION')
                    ->setCellValue('F1', 'FECHA ENTREGA')
                    ->setCellValue('G1', 'USER NAME')
                    ->setCellValue('H1', 'CODIGO')
                    ->setCellValue('I1', 'REFERENCIA')
                    ->setCellValue('J1', 'TALLA')
                    ->setCellValue('K1', 'VR UNITARIO')
                    ->setCellValue('L1', 'VR COSTO')
                    ->setCellValue('M1', 'CANTIDAD')
                    ->setCellValue('N1', 'OBSERVACION');
        $i = 2;
        
        foreach ($talla as $val){
                                  
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $val->cotizacion->numero_cotizacion)
                    ->setCellValue('C' . $i, $val->cotizacion->cliente->cedulanit)
                    ->setCellValue('D' . $i, $val->cotizacion->cliente->nombrecorto)
                    ->setCellValue('E' . $i, $val->cotizacion->fecha_cotizacion)
                    ->setCellValue('F' . $i, $val->cotizacion->fecha_entrega)
                    ->setCellValue('G' . $i, $val->cotizacion->user_name)
                    ->setCellValue('H' . $i, $val->detalleCotizacion->codigo)
                    ->setCellValue('I' . $i, $val->detalleCotizacion->referencia)
                    ->setCellValue('J' . $i, $val->talla->nombre_talla)
                    ->setCellValue('K' . $i, $val->detalleCotizacion->valor_unidad)
                    ->setCellValue('L' . $i, $val->detalleCotizacion->codigoReferencia->costo_producto)
                    ->setCellValue('M' . $i, $val->cantidad)
                    ->setCellValue('N' . $i, $val->detalleCotizacion->nota);
                   
            $i++;
        }
            
        $objPHPExcel->getActiveSheet()->setTitle('Listado');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Cotizacion_cliente.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
        exit;
    }
}
