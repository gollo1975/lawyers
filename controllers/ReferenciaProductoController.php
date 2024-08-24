<?php

namespace app\controllers;

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
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use Codeception\Lib\HelperModule;

//MODELSS
use app\models\ReferenciaProducto;
use app\models\UsuarioDetalle;
use app\models\GrupoReferencia;
/**
 * ReferenciaProductoController implements the CRUD actions for ReferenciaProducto model.
 */
class ReferenciaProductoController extends Controller
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
     * Lists all ReferenciaProducto models.
     * @return mixed
     */
     public function actionIndex() {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',5])->all()){
                $form = new \app\models\FiltroBusquedaReferencia();
                $codigo = null;
                $referencia = null;
                $grupo = null;
                if ($form->load(Yii::$app->request->get())) {
                    if ($form->validate()) {                        
                        $codigo = Html::encode($form->codigo);
                        $referencia = Html::encode($form->referencia);
                        $grupo = Html::encode($form->grupo);
                        $table = ReferenciaProducto::find()
                                ->andFilterWhere(['=', 'codigo', $codigo])                                                                                              
                                ->andFilterWhere(['like', 'descripcion_referencia', $referencia])
                                ->andFilterWhere(['=','id_grupo', $grupo]);
 
                        $table = $table->orderBy('codigo DESC');
                        $tableexcel = $table->all();
                        $count = clone $table;
                        $to = $count->count();
                        $pages = new Pagination([
                            'pageSize' => 10,
                            'totalCount' => $count->count()
                        ]);
                        $model = $table
                                ->offset($pages->offset)
                                ->limit($pages->limit)
                                ->all();
                            if(isset($_POST['excel'])){                            
                                $check = isset($_REQUEST['codigo DESC']);
                                $this->actionExcelConsultaReferencias($tableexcel);
                            }
                } else {
                        $form->getErrors();
                }                    
            } else {
                $table = ReferenciaProducto::find()
                        ->orderBy('codigo DESC');
                $tableexcel = $table->all();
                $count = clone $table;
                $pages = new Pagination([
                    'pageSize' => 10,
                    'totalCount' => $count->count(),
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                if(isset($_POST['excel'])){
                    //$table = $table->all();
                    $this->actionExcelconsultaReferencias($tableexcel);
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
     * Displays a single ReferenciaProducto model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $lista_precio = \app\models\ReferenciaListaPrecio::find()->where(['=','codigo', $id])->all();
        $simulador = \app\models\ReferenciaSimulador::find()->where(['=','codigo', $id])->all();
        $item = \app\models\Documentodir::findOne(1);
        $imagenes = \app\models\DirectorioArchivos::find()->where(['=', 'codigo', $id])->andWhere(['=', 'numero', $item->codigodocumento])->all();
        if (isset($_POST["actualizar_precio_venta"])) {
            if (isset($_POST["listado_precios"])) {
                 $intIndice = 0;
                foreach ($_POST["listado_precios"] as $intCodigo) {
                    $table = \app\models\ReferenciaListaPrecio::findOne($intCodigo);
                    $table->valor_venta = $_POST["precio_venta_publico"][$intIndice];
                    $table->id_lista  = $_POST["lista_precio"][$intIndice];
                    $table->save();
                   $intIndice++;
                }
                return $this->redirect(['view','id' => $id]);
            }
        }    
              
        //ACTUALIZA LOS COSTO DE INSUMOS
         if (isset($_POST["actualizar_lineas_insumos"])) {
            if (isset($_POST["listado_insumos"])) {
                 $intIndice = 0;
                foreach ($_POST["listado_insumos"] as $intCodigo) {
                    $table = \app\models\ReferenciaSimulador::findOne($intCodigo);
                    $table->valor_costo = $_POST["valor_costo"][$intIndice];
                    $table->cantidad  = $_POST["cantidad"][$intIndice];
                    $table->total_linea = round($table->valor_costo * $table->cantidad);
                    $table->save();
                    $intIndice++;
                }
                $this->SumarLineasCosto($id);
                return $this->redirect(['view','id' => $id]);
            }
        }    
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'lista_precio' => $lista_precio,
            'simulador' => $simulador,
            'imagenes' => $imagenes,
        ]);
    }
    
    //PROCESO QUE ACTUALIZA EL COSTO
    protected function SumarLineasCosto($id) {
        $referencia = ReferenciaProducto::findOne($id);
        $simular = \app\models\ReferenciaSimulador::find()->where(['=','codigo', $id])->all();
        $total = 0;
        foreach ($simular as $valor):
            $total += $valor->total_linea;
        endforeach;
        $referencia->costo_producto = $total;
        $referencia->save();
    }
    
       /**
     * Creates a new ReferenciaProducto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReferenciaProducto();
        

        if ($model->load(Yii::$app->request->post())) {
            $empresa = \app\models\Matriculaempresa::findOne(1);
            $codigo = $this->CrearCodigoReferencia();
            $model->codigo = $codigo;
            $model->descripcion_referencia = $model->descripcion_referencia;
            $model->id_grupo = $model->id_grupo;
            $model->user_name = Yii::$app->user->identity->username;
            $model->descripcion= $model->descripcion;
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'Se creo el registro en la base de datos con Exito.');
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            
        ]);
    }
    
    ///consecutivo del codigo de la referencia
    protected function CrearCodigoReferencia() {
        $Dato = \app\models\Consecutivo::findOne(1);
        $codigo = $Dato->consecutivo + 1;
        $Dato->consecutivo = $codigo;
        $Dato->save();
        return ($codigo);
    }

    
        //modificar cantidades produccion
    public function actionSubir_nota($id, $id_referencia) {
        $model = new \app\models\ModeloBuscar();
        $table = \app\models\ReferenciaListaPrecio::findOne($id_referencia);
       
        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST["grabar_nota"])) { 
                $table->nota = $model->nota;
                $table->save(false);
                $this->redirect(["referencia-producto/view", 'id' => $id]);
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
    
    /**
     * Updates an existing ReferenciaProducto model.
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
     * Deletes an existing ReferenciaProducto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    //PROCESO QUE CREA EL NUEVO PRECIO
    public function actionNuevo_precio_venta($id) {
        $model = new \app\models\ModeloPrecioVenta();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                if (isset($_POST["crear_precio"])) {
                    if($model->nuevo_precio > 0){
                        $table = new \app\models\ReferenciaListaPrecio();
                        $table->codigo = $id;
                        $table->valor_venta = $model->nuevo_precio;
                        $table->user_name = Yii::$app->user->identity->username;
                        $table->save(false);
                        $this->redirect(["referencia-producto/view", 'id' => $id]);
                    }else{
                        Yii::$app->getSession()->setFlash('warning', 'No se asignó ningun precio de venta a público. Ingrese nuevamente.'); 
                        return $this->redirect(["referencia-producto/view", 'id' => $id]);
                    }    
                }    
            }else{
                $model->getErrors();
            }    
        }
        return $this->renderAjax('new_precio_venta', [
            'model' => $model,
            'id' => $id,
        ]);
    }    
    
    //BUSCA INSUMOS PARA AGREGAR AL SIMULADOR
    public function actionBuscar_insumos($id){
        $operacion = \app\models\Insumos::find()->orderBy('nombre_insumo ASC')->all();
        $form = new \app\models\ModeloBuscar();
        $nombre_insumo = null;
        $clasificacion = null;
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $nombre_insumo = Html::encode($form->nombre_insumo);  
                $clasificacion = Html::encode($form->clasificacion); 
                $operacion = \app\models\Insumos::find()
                        ->andFilterWhere(['like','nombre_insumo',$nombre_insumo])
                        ->andFilterWhere(['=','id_clasificacion', $clasificacion]);
                $operacion = $operacion->orderBy('nombre_insumo ASC');                    
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
            $operacion = \app\models\Insumos::find()->orderBy('nombre_insumo ASC');
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
         if (isset($_POST["enviar_insumos"])) {
            if(isset($_POST["codigo_insumo"])){
                $intIndice = 0;
                foreach ($_POST["codigo_insumo"] as $intCodigo) {
                    $registro = \app\models\ReferenciaSimulador::find()->where(['=','id_insumo', $intCodigo])->andWhere(['=','codigo', $id])->one();
                    if(!$registro){
                        $item = \app\models\Insumos::findOne($intCodigo);
                        $table = new \app\models\ReferenciaSimulador();
                        $table->id_insumo = $intCodigo;
                        $table->valor_costo = $item->valor_costo;
                        $table->cantidad = 1;
                        $table->codigo = $id;
                        $table->user_name = Yii::$app->user->identity->username;
                        $table->save(false);
                    }    
                }
                return $this->redirect(['view','id' => $id]);
            }
        }
        return $this->render('importar_insumo', [
            'operacion' => $operacion,            
            'pagination' => $pages,
            'id' => $id,
            'form' => $form,

        ]);
    }
    
     //PROCESO QUE VALIDA LA CARGA DE IMAGENES DEL PRODUCTO
     public function actionValidador_imagen($token = 0) {
       if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',13])->all()){
                $form = new \app\models\ModeloBuscar();
                $codigo = null;
                $referencia = null;
                if ($form->load(Yii::$app->request->get())) {
                    if ($form->validate()) {
                        $codigo = Html::encode($form->codigo);
                        $referencia = Html::encode($form->referencia);
                        $table = ReferenciaProducto::find()
                                ->andFilterWhere(['like','descripcion_referencia', $referencia])
                                ->andFilterWhere(['=','codigo', $codigo]);
                        $table = $table->orderBy('codigo ASC');  
                        $tableexcel = $table->all();
                        $count = clone $table;
                        $to = $count->count();
                        $pages = new Pagination([
                            'pageSize' => 6,
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
                    $table = ReferenciaProducto::find()->orderBy('codigo ASC');
                    $tableexcel = $table->all();
                    $count = clone $table;
                    $pages = new Pagination([
                        'pageSize' => 6,
                        'totalCount' => $count->count(),
                    ]);
                    $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                }

                $to = $count->count();
                return $this->render('validador_archivo_imagenes', [
                            'model' => $model,
                            'form' => $form,
                            'pagination' => $pages,
                            'token' => $token,
                ]);
            }else{
                return $this->redirect(['site/sinpermiso']);
            }
        }else{
            return $this->redirect(['site/login']);
        }    
    }
   

    /**
     * Finds the ReferenciaProducto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReferenciaProducto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReferenciaProducto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
      public function actionExcelConsultaReferencias($tableexcel) {                
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
          
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'CODIGO')
                    ->setCellValue('B1', 'REFERENCIA')
                    ->setCellValue('C1', 'GRUPO')
                    ->setCellValue('D1', 'CODIGO HOMOLOGADO')
                    ->setCellValue('E1', 'NOTA CORMERCIAL')
                    ->setCellValue('F1', 'FICHA TECNICA')
                    ->setCellValue('G1', 'COSTO PRODUCTO')
                    ->setCellValue('H1', 'FECHA REGISTRO')
                    ->setCellValue('I1', 'USUARIO');
                                    
        $i = 2;
        
        foreach ($tableexcel as $val) {
                                  
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val->codigo)
                    ->setCellValue('B' . $i, $val->descripcion_referencia)
                    ->setCellValue('C' . $i, $val->grupo->concepto)
                    ->setCellValue('D' . $i, $val->codigo_homologado)
                    ->setCellValue('E' . $i, $val->nota_comercial)
                    ->setCellValue('F' . $i, $val->descripcion)
                    ->setCellValue('G' . $i, $val->costo_producto)
                    ->setCellValue('H' . $i, $val->fecha_registro)
                    ->setCellValue('I' . $i, $val->user_name);
                  
            $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('cliente');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Referencias.xlsx"');
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
