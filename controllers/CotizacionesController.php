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
     public function actionIndex() {
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
    public function actionView($id)
    {
        $referencias = \app\models\CotizacionDetalle::find()->where(['=','id_cotizacion', $id])->all();
        //actualiza los regisgtros de las referencias
        if (isset($_POST["actualizar_linea"])) {
            $intIndice = 0;
            $variable = 0;
            foreach ($_POST["listado_referencia"] as $intCodigo) {
                $variable = $_POST["tipo_lista"][$intIndice];
                $BuscarLista = \app\models\ReferenciaListaPrecio::findOne($variable);
                $table = \app\models\CotizacionDetalle::findOne($intCodigo);
                $table->id_detalle = $_POST["tipo_lista"][$intIndice];
                $table->valor_unidad = $BuscarLista->valor_venta;
                $table->save();
                if($table->cantidad_referencia > 0){
                    $id_referencia = $intCodigo;
                    $this->ContarCantidadTalla($id_referencia);
                }
                $intIndice++;
            } 
             return $this->redirect(['cotizaciones/view', 'id' => $id]);
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
                            $this->redirect(["cotizaciones/view", 'id' => $id]);
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
            'model' => $this->findModel($id),
            'referencias' => $referencias,
        ]);
    }
    
    //PERMITE VER LAS TALLAS DE LA REFERENCIA
    public function actionVer_tallas($id, $id_referencia) {
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
             return $this->redirect(['cotizaciones/ver_tallas', 'id' => $id,'id_referencia' => $id_referencia]);
        }    
         return $this->render('ver_tallas', [
            'id' => $id,
            'tallas_referencia' => $tallas_referencia,
            'model' => $model,
            'id_referencia' => $id_referencia,
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
        $referencia->save();
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
       $referencia->save();
    }
   
    //PROCESO QUE ELIMINA UN TALLA DEL LISTADO DE TALLAS
    public function actionEliminar_lineas($id_talla, $id_referencia, $id)
    {
        $dato = \app\models\CotizacionDetalleTalla::findOne($id_talla);
        $dato->delete();
        $this->ContarCantidadTalla($id_referencia);
       return $this->redirect(['cotizaciones/ver_tallas', 'id' => $id,'id_referencia' => $id_referencia]);
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
    public function actionAutorizado($id) {
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
                        return $this->redirect(['cotizaciones/view', 'id' => $id]);
                   }else{
                       Yii::$app->getSession()->setFlash('error','Favor ingresar las tallas y las cantidades de cada referencia para autorizar la cotización. ');
                         return $this->redirect(['cotizaciones/view', 'id' => $id]);
                   }
               }else{
                  Yii::$app->getSession()->setFlash('warning','Favor ingresar las tallas a cada referencia para autorizar la cotizacion. ');
                  return $this->redirect(['cotizaciones/view', 'id' => $id]);  
               }
               
           }else{
                Yii::$app->getSession()->setFlash('warning','Selecciona las listas de precio y presiona ACTUALIZAR. Luego debe de ingresar las tallas de cada referencias. ');
                return $this->redirect(['cotizaciones/view', 'id' => $id]);   
           }
        }else{
            Yii::$app->getSession()->setFlash('error', 'No hay REFERENCIAS asignadas a la cotizacion del cliente ('.$pedido->cliente->nombrecorto. ').');
            return $this->redirect(['cotizaciones/view', 'id' => $id]); 
        }
    }
    
    //PROCESO QUE CIERRA EL PEDIDO
    public function actionCerrar_pedido($id) {
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
        return $this->redirect(['cotizaciones/view', 'id' => $id]); 
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
    
    
     //BUSCA INSUMOS PARA AGREGAR AL SIMULADOR
    public function actionCargar_nueva_referencia($id){
        $operacion = \app\models\ReferenciaProducto::find()->where(['>','costo_producto', 0])->orderBy('descripcion_referencia ASC')->all();
        $form = new \app\models\ModeloBuscar();
        $referencia = null;
        $clasificacion = null;
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
                    'pageSize' => 15,
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
                        'pageSize' => 15,
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
                        $table->save(false);
                    }    
                }
                return $this->redirect(['view','id' => $id]);
            }
        }
        return $this->render('importar_referencias', [
            'operacion' => $operacion,            
            'pagination' => $pages,
            'id' => $id,
            'form' => $form,

        ]);
    }
    
    //CREAR TALLAS
     public function actionCrear_tallas_referencia($id, $id_referencia){
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
                $this->redirect(["cotizaciones/view", 'id' => $id]);
        }
        return $this->render('crear_tallas', [
            'tallas' => $tallas,            
            'id' => $id,
            'form' => $form,
            'id_referencia' => $id_referencia,
        ]);
    
    }
    
     //modificar cantidades produccion
    public function actionSubir_nota($id, $id_referencia) {
        $model = new \app\models\ModeloBuscar();
        $table = \app\models\CotizacionDetalle::findOne($id_referencia);
       
        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST["grabar_nota"])) { 
                $table->nota = $model->nota;
                $table->save(false);
                $this->redirect(["cotizaciones/view", 'id' => $id]);
            }    
        }
         if (Yii::$app->request->get()) {
            $model->nota = $table->nota; 
         }
        return $this->renderAjax('nota_referencia', [
            'model' => $model,
            'id_referencia' => $id_referencia,
            'id' => $id,
        ]);
    }
    
    //PERMITE IMPRIMIR
    public function actionImprimir_pedido($id)
    {
        return $this->render('../formatos/reporte_pedido_cliente', [
            'model' => $this->findModel($id),
            
        ]);
    }
    
    public function actionImprimir_tallas($id)
    {
        return $this->render('../formatos/reporte_pedido_tallas', [
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

        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'No PEDIDO')
                    ->setCellValue('C1', 'DOCUMENTO')
                    ->setCellValue('D1', 'CLIENTE')
                    ->setCellValue('E1', 'FECHA PEDIDO')
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
                    ->setCellValue('P1', 'CANTIDAD')
                    ->setCellValue('Q1', 'SUBTOTA')
                    ->setCellValue('R1', 'IVA')
                    ->setCellValue('S1', 'TOTAL LINEA');
        $i = 2;
        
        foreach ($tableexcel as $val) {
            $referencias  = PedidoClienteReferencias::find()->where(['=','id_pedido', $val->id_pedido])->all();
            foreach ($referencias as $referencia){
                                  
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $val->id_pedido)
                        ->setCellValue('B' . $i, $val->numero_pedido)
                        ->setCellValue('C' . $i, $val->cliente->cedulanit)
                        ->setCellValue('D' . $i, $val->cliente->nombrecorto)
                        ->setCellValue('E' . $i, $val->fecha_pedido)
                        ->setCellValue('F' . $i, $val->fecha_entrega)
                        ->setCellValue('G' . $i, $val->total_unidades)
                        ->setCellValue('H' . $i, $val->valor_total)
                        ->setCellValue('I' . $i, $val->impuesto)
                        ->setCellValue('J' . $i, $val->total_pedido)
                        ->setCellValue('K' . $i, $val->pedidoCerrado)
                        ->setCellValue('L' . $i, $val->user_name)
                        ->setCellValue('M' . $i, $referencia->codigo)
                        ->setCellValue('N' . $i, $referencia->referencia)
                        ->setCellValue('O' . $i, $referencia->valor_unitario)
                        ->setCellValue('P' . $i, $referencia->cantidad)
                        ->setCellValue('Q' . $i, $referencia->subtotal)
                        ->setCellValue('R' . $i, $referencia->iva)
                        ->setCellValue('S' . $i, $referencia->total_linea);
                $i++;
            }
            $i = $i;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Listado');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Pedido_cliente.xlsx"');
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
