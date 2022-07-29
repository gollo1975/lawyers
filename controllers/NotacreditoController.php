<?php

namespace app\controllers;

use app\models\Consecutivo;
use app\models\Conceptonota;
use app\models\Facturaventa;
use app\models\Notacreditodetalle;
use app\models\Cliente;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use Yii;
use app\models\Notacredito;
use app\models\NotacreditoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\UsuarioDetalle;

/**
 * NotacreditoController implements the CRUD actions for Notacredito model.
 */
class NotacreditoController extends Controller
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
     * Lists all Notacredito models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',38])->all()){
                $searchModel = new NotacreditoSearch();
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
     * Displays a single Notacredito model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modeldetalles = Notacreditodetalle::find()->Where(['=', 'idnotacredito', $id])->all();
        $modeldetalle = new Notacreditodetalle();
        $mensaje = "";
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modeldetalle' => $modeldetalle,
            'modeldetalles' => $modeldetalles,
            'mensaje' => $mensaje,

        ]);
    }

    /**
     * Creates a new Notacredito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notacredito();
        $clientes = Cliente::find()->all();
        $conceptonotacredito = Conceptonota::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->usuariosistema = Yii::$app->user->identity->username;
            $model->update();
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'clientes' => ArrayHelper::map($clientes, "idcliente", "nombreClientes"),
            'conceptonotacredito' => ArrayHelper::map($conceptonotacredito, "idconceptonota", "concepto"),

        ]);
    }

    /**
     * Updates an existing Notacredito model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $clientes = Cliente::find()->all();
        $conceptonotacredito = Conceptonota::find()->all();
        if(Notacreditodetalle::find()->where(['=', 'idnotacredito', $id])->all()){
           Yii::$app->getSession()->setFlash('warning', 'No se puede modificar la información, tiene detalles asociados');
        }
        else if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'clientes' => ArrayHelper::map($clientes, "idcliente", "nombreClientes"),
            'conceptonotacredito' => ArrayHelper::map($conceptonotacredito, "idconceptonota", "concepto"),
        ]);
    }

    /**
     * Deletes an existing Notacredito model.
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
            $this->redirect(["notacredito/index"]);
        } catch (IntegrityException $e) {
            $this->redirect(["notacredito/index"]);
            Yii::$app->getSession()->setFlash('error', 'Error al eliminar la nota crédito, tiene registros asociados en otros procesos');
        } catch (\Exception $e) {            
            Yii::$app->getSession()->setFlash('error', 'Error al eliminar la nota crédito, tiene registros asociados en otros procesos');
            $this->redirect(["notacredito/index"]);
        }
    }

    public function actionNuevodetalles($idcliente,$idnotacredito)
    {

        $notacreditoFactura = Facturaventa::find()
            ->where(['=', 'idcliente', $idcliente])
            ->andWhere(['=', 'autorizado', 1])->andWhere(['<>', 'nro_factura', 0])
            ->andWhere(['>', 'saldo', 0])
            ->all();
        $mensaje = "";
        if(Yii::$app->request->post()) {
            if (isset($_POST["idfactura"])) {
                $intIndice = 0;
                foreach ($_POST["idfactura"] as $intCodigo) {
                    $table = new Notacreditodetalle();
                    $factura = Facturaventa::find()->where(['idfactura' => $intCodigo])->one();
                    $detalles = Notacreditodetalle::find()
                        ->where(['=', 'idfactura', $factura->idfactura])
                        ->andWhere(['=', 'idnotacredito', $idnotacredito])
                        ->all();
                    $reg = count($detalles);
                    if ($reg == 0) {
                        $table->idfactura = $factura->idfactura;
                        $table->nrofactura = $factura->nro_factura;
                        $table->valor = $factura->saldo;
                        $table->idnotacredito = $idnotacredito;
                        $table->insert();
                    }
                }
                $this->redirect(["notacredito/view", 'id' => $idnotacredito]);
            } else {
                $mensaje = "Debe seleccionar al menos un registro";
            }
        }
        return $this->render('_formnuevodetalles', [
            'notacreditoFactura' => $notacreditoFactura,
            'idnotacredito' => $idnotacredito,
            'mensaje' => $mensaje,

        ]);
    }

    public function actionEditardetalle()
    {
        $iddetallenota = Html::encode($_POST["iddetallenota"]);
        $idnotacredito = Html::encode($_POST["idnotacredito"]);

        if(Yii::$app->request->post()){

            if((int) $iddetallenota)
            {
                $table = Notacreditodetalle::findOne($iddetallenota);
                if ($table) {
                    $table->valor = Html::encode($_POST["valor"]);
                    $table->idnotacredito = Html::encode($_POST["idnotacredito"]);
                    $table->update();
                    $this->redirect(["notacredito/view",'id' => $idnotacredito]);
                } else {
                    $msg = "El registro seleccionado no ha sido encontrado";
                    $tipomsg = "danger";
                }
            }
        }
        //return $this->render("_formeditardetalle", ["model" => $model,]);
    }

    public function actionEliminardetalle()
    {
        if(Yii::$app->request->post())
        {
            $iddetallenota = Html::encode($_POST["iddetallenota"]);
            $idnotacredito = Html::encode($_POST["idnotacredito"]);
            if((int) $iddetallenota)
            {
                $notacreditoDetalle = Notacreditodetalle::findOne($iddetallenota);
                $total = $notacreditoDetalle->valor;
                if(Notacreditodetalle::deleteAll("iddetallenota=:iddetallenota", [":iddetallenota" => $iddetallenota]))
                {
                    $this->redirect(["notacredito/view",'id' => $idnotacredito]);
                }
                else
                {
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("notacredito/index")."'>";
                }
            }
            else
            {
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("notacredito/index")."'>";
            }
        }
        else
        {
            return $this->redirect(["notacredito/index"]);
        }
    }

    public function actionEditardetalles($idnotacredito)
    {
        $mds = Notacreditodetalle::find()->where(['=', 'idnotacredito', $idnotacredito])->all();

        if (isset($_POST["iddetallenota"])) {
            $intIndice = 0;
            foreach ($_POST["iddetallenota"] as $intCodigo) {
                if($_POST["valor"][$intIndice] > 0 ){
                    $table = Notacreditodetalle::findOne($intCodigo);
                    //$total = $table->valor;
                    $table->valor = $_POST["valor"][$intIndice];
                    $table->update();
                }
                $intIndice++;
            }
            $this->redirect(["notacredito/view",'id' => $idnotacredito]);
        }
        return $this->render('_formeditardetalles', [
            'mds' => $mds,
            'idnotacredito' => $idnotacredito,
        ]);
    }

    public function actionEliminardetalles($idnotacredito)
    {
        $mds = Notacreditodetalle::find()->where(['=', 'idnotacredito', $idnotacredito])->all();
        $mensaje = "";
        if(Yii::$app->request->post())
        {
            $intIndice = 0;

            if (isset($_POST["seleccion"])) {
                foreach ($_POST["seleccion"] as $intCodigo)
                {
                    $notacreditoDetalle = Notacreditodetalle::findOne($intCodigo);
                    $total = $notacreditoDetalle->valor;
                    if(Notacreditodetalle::deleteAll("iddetallenota=:iddetallenota", [":iddetallenota" => $intCodigo]))
                    {

                    }
                }
                $this->redirect(["notacredito/view",'id' => $idnotacredito]);
            }else {
                $mensaje = "Debe seleccionar al menos un registro";
            }
        }
        return $this->render('_formeliminardetalles', [
            'mds' => $mds,
            'idnotacredito' => $idnotacredito,
            'mensaje' => $mensaje,
        ]);
    }

    public function actionAutorizado($id)
    {
        $model = $this->findModel($id);
        $mensaje = "";
        if ($model->autorizado == 0){
            $detalles = Notacreditodetalle::find()
                ->where(['=', 'idnotacredito', $id])
                ->all();
            $reg = count($detalles);
            if ($reg <> 0) {
                list($error,$totalabono,$saldo) = $this->ValorNotaCredito($id); //se valida si la nota credito es mayor al saldo
                if ($error == 0){
                    $model->autorizado = 1;
                    $model->update();
                    $this->redirect(["notacredito/view",'id' => $id]);
                }else{
                    if ($error == 1){
                        Yii::$app->getSession()->setFlash('error', 'EL valor de la nota crédito $'.number_format($totalabono,0).' no puede ser mayor al saldo $'.number_format($saldo,0));
                        $this->redirect(["notacredito/view",'id' => $id]);
                    }else{
                        if($error == 2){
                            Yii::$app->getSession()->setFlash('error', 'EL valor de la nota crédito no puede ser 0 o negativo');
                            $this->redirect(["notacredito/view",'id' => $id]);
                        }
                    }
                }
            }else{
                Yii::$app->getSession()->setFlash('error', 'Para autorizar el registro, debe tener productos relacionados en la nota de crédito.');
                $this->redirect(["notacredito/view",'id' => $id]);
            }
        } else {
            $model->autorizado = 0;
            $model->update();
            $this->redirect(["notacredito/view",'id' => $id]);
        }
    }

    public function actionNotacredito($id)
    {
        $model = $this->findModel($id);
        $mensaje = "";
        if ($model->autorizado == 1){
            if ($model->valor == 0){
                $notacreditodetalles = Notacreditodetalle::find()
                    ->where(['idnotacredito' => $id])
                    ->all();
                $subtotal = 0;

                $nuevosaldo = 0;
                $total = 0;
                $totaliva = 0;
                $iva = 0;
                $totalreteiva = 0;
                $reteiva = 0;
                $totalretefuente = 0;
                $retefuente = 0;
                list($error,$totalabono,$saldo) = $this->ValorNotaCredito($id); //se valida si la nota credito es mayor al saldo
                if ($error == 0){
                    foreach ($notacreditodetalles as $val) {
                        $factura = Facturaventa::findOne($val->idfactura);

                        $iva = $val->valor * $factura->porcentajeiva / 100;
                        if($factura->retencioniva > 0){
                            $reteiva = $iva * $factura->porcentajereteiva / 100;
                        }
                        if($factura->retencionfuente > 0){
                            $retefuente = $val->valor * $factura->porcentajefuente / 100;
                        }
                        $subtotal = $subtotal + $val->valor;
                        $totaliva = $totaliva + $iva;
                        $totalreteiva = $totalreteiva + $reteiva;
                        $totalretefuente = $totalretefuente + $retefuente;

                        $nuevosaldo = ($factura->saldo) - ($val->valor + $iva - $reteiva - $retefuente);

                        if($nuevosaldo <= 0){
                            $factura->estado = 3; //estado 0 = abieto, estado 1 = abono, estado 2 = pagada, estado 3 = anulada por notacredito (saldo 0 en la factura), estado 4 = descuento por nota credito
                            $factura->saldo = $nuevosaldo;
                        }
                        if ($nuevosaldo > 0){
                            $factura->estado = 4; //estado 0 = abieto, estado 1 = abono, estado 2 = pagada, estado 3 = anulada por notacredito (saldo 0 en la factura), estado 4 = descuento por nota credito
                            $factura->saldo = $nuevosaldo;
                        }
                        $factura->save(false);
                    }
                    $model->valor = round($subtotal,0);
                    $model->iva = round($totaliva,0);
                    $model->reteiva = round($totalreteiva,0);
                    $model->retefuente = round($totalretefuente,0);
                    $model->total = round($model->valor + $model->iva - $model->reteiva - $model->retefuente,0);
                    $model->fechapago = date('Y-m-d');
                    //generar consecutivo numero de la nota credito
                    $consecutivo = Consecutivo::findOne(2);//2 nota credito
                    $consecutivo->consecutivo = $consecutivo->consecutivo + 1;
                    $model->numero = $consecutivo->consecutivo;
                    $model->update();
                    $consecutivo->update();
                    //fin generar consecutivo                    
                    $this->redirect(["notacredito/view",'id' => $id]);
                } else {
                    if($error == 1){
                        Yii::$app->getSession()->setFlash('error', 'EL valor de la nota crédito $'.number_format($totalabono,0).' no puede ser mayor al saldo $'.number_format($saldo,0));
                        $this->redirect(["notacredito/view",'id' => $id]);
                    }else {
                        if($error == 2){
                            Yii::$app->getSession()->setFlash('error', 'EL valor de la nota crédito no puede ser 0 o negativo');
                            $this->redirect(["notacredito/view", 'id' => $id]);
                        }
                    }
                }
            }else{
                Yii::$app->getSession()->setFlash('error', 'Ya se realizo el descuento de la nota credito.');
                $this->redirect(["notacredito/view",'id' => $id]);
            }
        } else {
            Yii::$app->getSession()->setFlash('error', 'Para pagar el recibo de caja debe estar autorizado');
            $this->redirect(["notacredito/view",'id' => $id]);
        }
    }

    protected function ValorNotaCredito($id)
    {
        $notacreditodetalles = Notacreditodetalle::find()
            ->where(['idnotacredito' => $id])
            ->all();

        $error = 0;
        $iva = 0;
        $reteiva = 0;
        $retefuente = 0;
        foreach ($notacreditodetalles as $dato){ //se recorrer todos los registros de facturas para comprobar que el abono o nota credito no sea mayor al saldo
            $factura = Facturaventa::findOne($dato->idfactura);
            $iva = $dato->valor * $factura->porcentajeiva / 100;
            if($factura->retencioniva > 0){
                $reteiva = $iva * $factura->porcentajereteiva / 100;
            }
            if($factura->retencionfuente > 0){
                $retefuente = $dato->valor * $factura->porcentajefuente / 100;
            }
            $totalabono = $dato->valor + $iva - $reteiva - $retefuente;
            if (round($totalabono,0) > round($factura->saldo,0)){
                $error = 1;
            }else{
                if ($dato->valor <= 0){
                    $error = 2; //valor a ingresar es cero
                }
            }
        }
        return array($error,$totalabono,$factura->saldo);
    }

    /**
     * Finds the Notacredito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notacredito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notacredito::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionImprimir($id)
    {                                
        return $this->render('../formatos/notaCredito', [
            'model' => $this->findModel($id),
            
        ]);
    }
}
