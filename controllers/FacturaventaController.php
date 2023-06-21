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
use yii\web\UploadedFile;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use Codeception\Lib\HelperModule;
use yii\db\Expression;
use yii\db\Query;

//modelos
use app\models\Facturaventa;
use app\models\FacturaventaSearch;
use app\models\Facturaventadetalle;
use app\models\TipoFactura;
use app\models\UsuarioDetalle;
use app\models\FormFiltroFacturaVenta;
use app\models\Cliente;
use app\models\Demandas;
use app\models\Matriculaempresa;
use app\models\ServicioPrestado;

/**
 * FacturaventaController implements the CRUD actions for Facturaventa model.
 */
class FacturaventaController extends Controller
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
     * Lists all Facturaventa models.
     * @return mixed
     */
    public function actionIndex() {
        if (Yii::$app->user->identity){
        if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',14])->all()){
            $form = new FormFiltroFacturaVenta();
            $idcliente = null;
            $nro_factura = null;
            $fecha_inicio = null;
            $fecha_vencimiento = null;
            $tipo_factura= NULL;
            if ($form->load(Yii::$app->request->get())) {
                if ($form->validate()) {
                    $idcliente = Html::encode($form->idcliente);
                    $nro_factura = Html::encode($form->nro_factura);
                    $fecha_inicio = Html::encode($form->fecha_inicio);
                    $fecha_vencimiento = Html::encode($form->fecha_vencimiento);
                    $tipo_factura = Html::encode($form->tipo_factura);
                    $table = Facturaventa::find()
                            ->andFilterWhere(['=', 'idcliente', $idcliente])
                            ->andFilterWhere(['=', 'nro_factura', $nro_factura])
                            ->andFilterWhere(['>=', 'fecha_inicio', $fecha_inicio])
                            ->andFilterWhere(['<=', 'fecha_inicio', $fecha_vencimiento])
                            ->andFilterWhere(['=', 'tipo_factura', $tipo_factura]);
                    $table = $table->orderBy('idfactura desc');
                    $tableexcel = $table->all();
                    $count = clone $table;
                    $to = $count->count();
                    $pages = new Pagination([
                        'pageSize' => 25,
                        'totalCount' => $count->count()
                    ]);
                    $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                    if(isset($_POST['excel'])){
                        //$table = $table->all();
                        $this->actionExcelconsultaFacturasVenta($tableexcel);
                    }
                } else {
                    $form->getErrors();
                }
            } else {
                $table = Facturaventa::find()
                        ->orderBy('idfactura desc');
                $tableexcel = $table->all();
                $count = clone $table;
                $pages = new Pagination([
                    'pageSize' => 25,
                    'totalCount' => $count->count(),
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                if(isset($_POST['excel'])){
                    //$table = $table->all();
                    $this->actionExcelconsultaFacturasVenta($tableexcel);
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

    //permite consultar las facturas
    public function actionIndexconsulta() {
        if (Yii::$app->user->identity){
        if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',28])->all()){
            $form = new FormFiltroFacturaVenta();
            $idcliente = null;
            $nro_factura = null;
            $fecha_inicio = null;
            $fecha_vencimiento = null;
            $tipo_factura= NULL;
            $pendiente = NULL;
            if ($form->load(Yii::$app->request->get())) {
                if ($form->validate()) {
                    $idcliente = Html::encode($form->idcliente);
                    $nro_factura = Html::encode($form->nro_factura);
                    $fecha_inicio = Html::encode($form->fecha_inicio);
                    $fecha_vencimiento = Html::encode($form->fecha_vencimiento);
                    $tipo_factura = Html::encode($form->tipo_factura);
                    $pendiente = Html::encode($form->pendiente);
                    $table = Facturaventa::find()
                            ->andFilterWhere(['=', 'idcliente', $idcliente])
                            ->andFilterWhere(['=', 'nro_factura', $nro_factura])
                            ->andFilterWhere(['>=', 'fecha_inicio', $fecha_inicio])
                            ->andFilterWhere(['<=', 'fecha_inicio', $fecha_vencimiento])
                            ->andFilterWhere(['=', 'tipo_factura', $tipo_factura]);
                    if ($pendiente == 1){
                        $table = $table->andFilterWhere(['>', 'saldo', $pendiente]);
                    }        
                    $table = $table->orderBy('idfactura desc');
                    $tableexcel = $table->all();
                    $count = clone $table;
                    $to = $count->count();
                    $pages = new Pagination([
                        'pageSize' => 25,
                        'totalCount' => $count->count()
                    ]);
                    $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                    if(isset($_POST['excel'])){
                        
                        $this->actionExcelconsultaFacturasVenta($tableexcel);
                    }
                } else {
                    $form->getErrors();
                }
            } else {
                $table = Facturaventa::find()
                        ->orderBy('idfactura desc');
                $count = clone $table;
                $pages = new Pagination([
                    'pageSize' => 25,
                    'totalCount' => $count->count(),
                ]);
                $tableexcel = $table->all();
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                if(isset($_POST['excel'])){                    
                    $this->actionExcelconsultaFacturasVenta($tableexcel);
                }
            }
            $to = $count->count();
            return $this->render('index_consulta', [
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
     * Displays a single Facturaventa model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modeldetalles = Facturaventadetalle::find()->Where(['=', 'idfactura', $id])->all();
        $mensaje = '';
        $modeldetalle = new Facturaventadetalle();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modeldetalle' => $modeldetalle,
            'modeldetalles' => $modeldetalles,
            'mensaje' => $mensaje,
        ]);
    }
    
     public function actionViewconsulta($id)
    {
        $modeldetalles = Facturaventadetalle::find()->Where(['=', 'idfactura', $id])->all();
        $modeldetalle = new Facturaventadetalle();
        $mensaje = "";                        
        return $this->render('view_consulta', [
            'model' => $this->findModel($id),
            'modeldetalle' => $modeldetalle,
            'modeldetalles' => $modeldetalles,
            'mensaje' => $mensaje,
        ]);
    }

    /**
     * Creates a new Facturaventa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Facturaventa();
         $config = Matriculaempresa::findOne(1);
        $tipo_factura = TipoFactura::find()->orderBy(('concepto ASC'))->all();
        $demandas = Demandas::find()->orderBy(('nro_demanda DESC'))->all();
        $clientes = Cliente::find()->orderBy('nombrecorto ASC')->all();
        $configuracion = Matriculaempresa::findOne(1);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $table = Cliente::find()->where(['=', 'idcliente', $model->idcliente])->one();
            $fecha = date( $model->fecha_inicio);
            $nuevafecha = strtotime ( '+'.$table->plazopago.' day' , strtotime ( $fecha ) ) ;
            $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
            $model->nro_factura = 0;
            $model->fecha_vencimiento = $nuevafecha;
            $model->formapago = $table->formapago;
            $model->plazopago = $table->plazopago;
            $model->porcentajefuente = 0;
            $model->porcentajereteiva = 0;
            $model->subtotal = 0;
            $model->retencionfuente = 0;
            $model->retencioniva = 0;
            $model->impuestoiva = 0;
            $model->saldo = 0;
            if($model->aplica_iva > 0){
                $model->aplica_iva = $model->aplica_iva;
                $model->porcentajeiva = $configuracion->porcentajeiva;
            }else{
              $model->aplica_iva = 0;
              $model->porcentajeiva = 0;
            }    
            $model->totalpagar = 0;
            $model->valorletras = "-" ;
            $model->nrofacturaelectronica = $model->nrofacturaelectronica;
            $model->usuariosistema = Yii::$app->user->identity->username;            
            $model->save(false);
         return $this->redirect(['view', 'id' => $model->idfactura]);
        }

        return $this->render('create', [
            'model' => $model,
            'config' => $config,
            'demandas' => ArrayHelper::map($demandas, "nro_demanda", "clase"),
            'tipo_factura' => ArrayHelper::map($tipo_factura, "tipo_factura", "concepto"),
            'clientes' => ArrayHelper::map($clientes, "idcliente", "nombreclientes"),
        ]);
    }

    /**
     * Updates an existing Facturaventa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $config = Matriculaempresa::findOne(1);
        $tipo_factura = TipoFactura::find()->orderBy(('concepto ASC'))->all();
        $demandas = Demandas::find()->orderBy(('nro_demanda DESC'))->all();
        $clientes = Cliente::find()->orderBy('nombrecorto ASC')->all();
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->aplica_iva == 1){
                $model->aplica_iva = $model->aplica_iva;
                $model->porcentajeiva = $config->porcentajeiva;
                $model->save();
            }else{
                $model->aplica_iva = 0;
                 $model->porcentajeiva = 0;
                $model->save();
            }
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'config' => $config,
            'demandas' => ArrayHelper::map($demandas, "nro_demanda", "clase"),
            'tipo_factura' => ArrayHelper::map($tipo_factura, "tipo_factura", "concepto"),
            'clientes' => ArrayHelper::map($clientes, "idcliente", "nombreclientes"),

        ]);
    }
    
    public function actionNuevodetalles($nro_demanda, $id)
    {
        $servicioPactado = \app\models\ServicioPrestado::find()->where(['=', 'nro_demanda', $nro_demanda])->andWhere(['>','saldo_servicio', 0])->orderBy('id_servicio DESC')->all();
        $mensaje = "";
        if (isset($_POST["id_servicio"])) {
            $intIndice = 0;
            foreach ($_POST["id_servicio"] as $intCodigo) {
                $table = new Facturaventadetalle();
                $servicioPactado = \app\models\ServicioPrestado::find()->where(['id_servicio' => $intCodigo])->one();
                $detalles = Facturaventadetalle::find()
                    ->where(['=', 'idfactura', $id])
                    ->andWhere(['=', 'id_factura_venta_tipo', $servicioPactado->id_factura_venta_tipo])
                    ->all();
                $reg = count($detalles);
                $total = 0;
                if ($reg == 0) {
                    $table->idfactura = $id;
                    $table->id_factura_venta_tipo = $servicioPactado->id_factura_venta_tipo;
                    $table->preciounitario = $servicioPactado->saldo_servicio;
                    $table->nro_demanda = $nro_demanda;
                    $table->cantidad = 1;
                    $table->total = $servicioPactado->saldo_servicio;
                    $total = $table->total;
                    $table->save(false);
                    $this->ValidarConceptoTributario($id);
                }
            }
            $this->redirect(["facturaventa/view", 'id' => $id]);
        }
        $servicioPactado = \app\models\ServicioPrestado::find()->where(['=', 'nro_demanda', $nro_demanda])->andWhere(['>','saldo_servicio', 0])->orderBy('id_servicio DESC')->all();
        return $this->render('_formnuevodetalles', [
            'servicioPactado' => $servicioPactado,
            'id' => $id,
            'mensaje' => $mensaje,
            'nro_demanda' => $nro_demanda,

        ]);
    }
    
    //editar ditalles de la factura
    
    public function actionEditardetalle(){
        $iddetallefactura = Html::encode($_POST["iddetallefactura"]);
        $id = Html::encode($_POST["idfactura"]);
        if(Yii::$app->request->post()){
            if((int) $iddetallefactura)
            {
                $table = Facturaventadetalle::findOne($iddetallefactura);
                if ($table) {
                    $table->cantidad = Html::encode($_POST["cantidad"]);
                    $table->preciounitario = Html::encode($_POST["preciounitario"]);
                    $table->total = Html::encode($_POST["cantidad"]) * Html::encode($_POST["preciounitario"]);
                    $table->save(false);
                    $this->ValidarConceptoTributario($id);
                    $this->redirect(["facturaventa/view",'id' => $id]);
                } else {
                    $msg = "El registro seleccionado no ha sido encontrado";
                    $tipomsg = "danger";
                }
            }
        }
    }
    
    //eliminar detalles individual
    public function actionEliminardetalle()
    {
        if(Yii::$app->request->post())
        {
            $iddetallefactura = Html::encode($_POST["iddetallefactura"]);
            $id = Html::encode($_POST["idfactura"]);
            if((int) $iddetallefactura)
            {
                $facturaDetalle = Facturaventadetalle::findOne($iddetallefactura);
                if(Facturaventadetalle::deleteAll("id_detalle=:id_detalle", [":id_detalle" => $iddetallefactura])){
                    $this->ValidarConceptoTributario($id);
                    $this->redirect(["facturaventa/view",'id' => $id]);
                }else{
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("facturaventa/index")."'>";
                }
            }else{
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("facturaventa/index")."'>";
            }
        }else{
            return $this->redirect(["facturaventa/index"]);
        }
    }

    protected function ValidarConceptoTributario($id) {
        //datos de entrada
        $factura = Facturaventa::findOne($id);
        $config = Matriculaempresa::findOne(1);
        $cliente = Cliente::findOne($factura->idcliente);
        $factura_detalle = Facturaventadetalle::find()->where(['idfactura' => $id])->all();
        $subtotal = 0;
        foreach ($factura_detalle as $detalles):
            $subtotal += $detalles->total;
        endforeach;
        $valorIva = 0; $valorRetencion = 0; $valorReteIva = 0;
        if($config->id_tipo_regimen == 1){
            $valorIva = round(($subtotal *  $factura->porcentajeiva)/100);
            $factura->impuestoiva = $valorIva;
            if($cliente->tiporegimen == 1){
                $factura->porcentajefuente = $factura->tipoFactura->porcentaje_retencion;
                if($cliente->retencionfuente == 1){
                    $valorRetencion = round(($subtotal * $factura->porcentajefuente)/100);
                    $factura->retencionfuente = $valorRetencion;  
                }
                if($cliente->autoretenedor == 1){
                    $valorReteIva = round(($valorIva * $config->porcentajereteiva)/100);
                    $factura->retencioniva = $valorReteIva;  
                    $factura->porcentajereteiva = $config->porcentajereteiva;
                }
                $factura->subtotal = $subtotal;
                $factura->totalpagar = round(($subtotal + $valorIva)- ($valorRetencion + $valorReteIva));
                $factura->saldo = $factura->totalpagar;
                $factura->save();
            }else{
                $factura->porcentajefuente = 0;
                $factura->retencionfuente = 0;
                $factura->retencioniva = 0;  
                $factura->porcentajereteiva = 0;
                $factura->subtotal = $subtotal;
                $factura->totalpagar = round($subtotal + $valorIva);
                $factura->saldo = round($subtotal + $valorIva);
                $factura->save(); 
            }
        }else{
            $factura->porcentajeiva = 0;
            $factura->impuestoiva = 0;
            $factura->porcentajefuente = 0;
            $factura->retencionfuente = 0;
            $factura->retencioniva = 0;  
            $factura->porcentajereteiva = 0;
            $factura->subtotal = $subtotal;
            $factura->totalpagar = $subtotal;
            $factura->saldo = $subtotal;
            $factura->save();
        }
    }

    /**
     * Deletes an existing Facturaventa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionAutorizado($id)
    {
        $model = $this->findModel($id);
        $mensaje = "";
        if ($model->autorizado == 0){
            $detalles = Facturaventadetalle::find()
                ->where(['=', 'idfactura', $id])
                ->all();
            $reg = count($detalles);
            if ($reg <> 0) {
                $model->autorizado = 1;
                $model->save(false);
                $this->redirect(["facturaventa/view",'id' => $id]);
            }else{
                Yii::$app->getSession()->setFlash('error', 'Para autorizar el registro, debe tener servicios creados en la factura de venta.');
                $this->redirect(["facturaventa/view",'id' => $id]);
            }
        } else {
            $factura = Facturaventa::findOne($id);
            if ($factura->nro_factura == 0){
                $model->autorizado = 0;
                $model->save(false);
                $this->redirect(["facturaventa/view",'id' => $id]);
            }else {
                Yii::$app->getSession()->setFlash('error', 'No se puede desautorizar el registro, ya fue generado el número de factura.');
                $this->redirect(["facturaventa/view",'id' => $id]);
            }
        }
    }
    
      public function actionGenerarnro($id)
    {
        $model = $this->findModel($id);
        $mensaje = "";
        if ($model->autorizado == 1){
            $factura = Facturaventa::findOne($id);
            $detalleFactura = Facturaventadetalle::find()->where(['=','idfactura', $id])->all();
            foreach ($detalleFactura as $detalle):
                $saldo = 0; $saldoReal = 0;
                $servicio = ServicioPrestado::find()->where(['=','id_factura_venta_tipo', $detalle->id_factura_venta_tipo])->andWhere(['=','nro_demanda', $factura->nro_demanda])->one();
                   if($detalle->id_factura_venta_tipo == $servicio->id_factura_venta_tipo){
                       $saldo = $servicio->saldo_servicio;
                       $saldoReal = $saldo - $detalle->total;
                       $servicio->saldo_servicio = $saldoReal;
                       $servicio->save();
                   }
            endforeach;
            
            if ($factura->nro_factura == 0){
                $consecutivo = \app\models\Consecutivo::findOne(1);// 1 factura de venta
                $consecutivo->consecutivo = $consecutivo->consecutivo + 1;
                $factura->nro_factura = $consecutivo->consecutivo;
                $factura->save(false);
                $consecutivo->save(false);
                $this->redirect(["facturaventa/view",'id' => $id]);
            }else{
                Yii::$app->getSession()->setFlash('error', 'El registro ya fue generado.');
                $this->redirect(["facturaventa/view",'id' => $id]);
            }
        }
    }
    //imprimir documento
     public function actionImprimir($id)
    {
                                
        return $this->render('../formatos/facturaVenta', [
            'model' => $this->findModel($id),
            
        ]);
    }

    //proceso que acciona el combo de cliente
    
     public function actionOrdenp($id){
        $rows = Demandas::find()->where(['idcliente' => $id])->orderBy('nro_demanda desc')->all();

        echo "<option value='' required>Seleccione...</option>";
        if(count($rows)>0){
            foreach($rows as $row){
                echo "<option value='$row->nro_demanda' required>$row->nro_demanda - $row->clase </option>";
            }
        }
    }
    /**
     * Finds the Facturaventa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Facturaventa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModel($id)
    {
        if (($model = Facturaventa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionExcelconsultaFacturasVenta($tableexcel) {                
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
                    ->setCellValue('A1', 'Id')
                    ->setCellValue('B1', 'N° Factura')
                    ->setCellValue('C1', 'N° Factura electronica')
                    ->setCellValue('D1', 'Cliente')
                    ->setCellValue('E1', 'Proceso')
                    ->setCellValue('F1', 'Tipo factura')
                    ->setCellValue('G1', 'Fecha Inicio')
                    ->setCellValue('H1', 'Fecha Vencimiento')
                    ->setCellValue('I1', 'Forma Pago')
                    ->setCellValue('J1', 'Plazo Pago')
                    ->setCellValue('K1', '% Iva')
                    ->setCellValue('L1', '% ReteFuente')
                    ->setCellValue('M1', '% ReteIva')
                    ->setCellValue('N1', 'Iva')
                    ->setCellValue('O1', 'ReteFuente')
                    ->setCellValue('P1', 'ReteIva')
                    ->setCellValue('Q1', 'Subtotal')                      
                    ->setCellValue('R1', 'Total')
                    ->setCellValue('S1', 'Saldo')
                    ->setCellValue('T1', 'Autorizado')
                    ->setCellValue('U1', 'Estado')
                    ->setCellValue('V1', 'Observacion');
        $i = 2;
        
        foreach ($tableexcel as $val) {
                                  
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val->idfactura)
                    ->setCellValue('B' . $i, $val->nro_factura)
                    ->setCellValue('C' . $i, $val->nrofacturaelectronica)
                    ->setCellValue('D' . $i, $val->cliente->nombrecorto)
                    ->setCellValue('E' . $i, $val->demanda->claseDemanda->concepto)
                    ->setCellValue('F' . $i, $val->tipoFactura->concepto)
                    ->setCellValue('G' . $i, $val->fecha_inicio)
                    ->setCellValue('H' . $i, $val->fecha_vencimiento)
                    ->setCellValue('I' . $i, $val->formaPago)
                    ->setCellValue('J' . $i, $val->plazopago)
                    ->setCellValue('K' . $i, $val->porcentajeiva)
                    ->setCellValue('L' . $i, $val->porcentajefuente)
                    ->setCellValue('M' . $i, $val->porcentajereteiva)
                    ->setCellValue('N' . $i, round($val->impuestoiva,0))
                    ->setCellValue('O' . $i, round($val->retencionfuente,0))
                    ->setCellValue('P' . $i, round($val->retencioniva,0))
                    ->setCellValue('Q' . $i, round($val->subtotal,0))                    
                    ->setCellValue('R' . $i, round($val->totalpagar,0))
                    ->setCellValue('S' . $i, round($val->saldo,0))
                    ->setCellValue('T' . $i, $val->autorizadoFactura)
                    ->setCellValue('U' . $i, $val->estadoFactura)
                    ->setCellValue('V' . $i, $val->observacion);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('facturas_de_venta');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="facturas_de_venta.xlsx"');
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
