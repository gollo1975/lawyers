<?php

namespace app\controllers;

//clases
use yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use Codeception\Lib\HelperModule;
//modelos
use app\models\FormFiltroCliente;
use app\models\FormFiltroConsultaCliente;
use app\models\UsuarioDetalle;
use app\models\Matriculaempresa;
use app\models\Cliente;
use app\models\Municipio;
use app\models\Departamentos;
use app\models\FormCliente;
use app\models\Ordenproduccion;

class ClientesController extends Controller {

    public function actionIndex($token = 0) {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',4])->all()){
                $form = new FormFiltroCliente;
                $cedulanit = null;
                $nombre_completo = null;
                if ($form->load(Yii::$app->request->get())) {
                    if ($form->validate()) {
                        $cedulanit = Html::encode($form->cedulanit);
                        $nombre_completo = Html::encode($form->nombre_completo);
                        $table = Cliente::find()
                                ->andFilterWhere(['like', 'cedulanit', $cedulanit])
                                ->andFilterWhere(['like', 'nombrecorto', $nombre_completo])
                                ->orderBy('idcliente desc');
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
                    } else {
                        $form->getErrors();
                    }
                    if(isset($_POST['excel'])){
                        //$table = $table->all();
                        $this->actionExcelDepartamento($tableexcel);
                    }
                } else {
                    $table = Cliente::find()
                            ->orderBy('idcliente desc');
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
                        $this->actionExcelDepartamento($tableexcel);
                     }    
                }
                $to = $count->count();
                return $this->render('index', [
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

    public function actionCreate() {
        $matriculaempresa = Matriculaempresa::findOne(1);
        $model = new FormCliente();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $dv = Html::encode($_POST["dv"]);
            if ($model->validate()) {
                $table = new Cliente();
                $table->id_tipo_documento = $model->id_tipo_documento;
                $table->cedulanit = $model->cedulanit;
                $table->razonsocial = $model->razonsocial;
                $table->nombrecliente = $model->nombrecliente;
                $table->apellidocliente = $model->apellidocliente;
                $table->direccioncliente = $model->direccioncliente;
                $table->telefonocliente = $model->telefonocliente;
                $table->celularcliente = $model->celularcliente;
                $table->emailcliente = $model->emailcliente;
                $table->iddepartamento = $model->iddepartamento;
                $table->idmunicipio = $model->idmunicipio;
                $table->nitmatricula = $matriculaempresa->nitmatricula;
                $table->observacion = $model->observacion;
                $table->dv = $dv;
                $table->usuario = Yii::$app->user->identity->username;
               if ($model->id_tipo_documento == 5) {
                    $table->nombrecorto = $model->razonsocial;
                    $model->nombrecliente = null;
                    $model->apellidocliente = null;
                }else{
                    $table->nombrecorto = strtoupper($model->nombrecliente . " " . $model->apellidocliente);
                    $model->razonsocial = null;
                }

                if ($table->save(false)) {
                    $this->redirect(["clientes/index"]);
                } 
            } else {
                $model->getErrors();
            }
        }
        return $this->render('_form', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $matriculaempresa = Matriculaempresa::findOne(1);
        $model = new FormCliente();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $dv = Html::encode($_POST["dv"]);
            if ($model->validate()) {
                $table = Cliente::find()->where(['idcliente' => $id])->one();
                if ($table) {
                    $table->id_tipo_documento = $model->id_tipo_documento;
                    $table->cedulanit = $model->cedulanit;
                    $table->razonsocial = $model->razonsocial;
                    $table->nombrecliente = $model->nombrecliente;
                    $table->apellidocliente = $model->apellidocliente;
                    $table->direccioncliente = $model->direccioncliente;
                    $table->telefonocliente = $model->telefonocliente;
                    $table->celularcliente = $model->celularcliente;
                    $table->emailcliente = $model->emailcliente;
                    $table->iddepartamento = $model->iddepartamento;
                    $table->idmunicipio = $model->idmunicipio;
                    $table->observacion = $model->observacion;
                    $table->dv = $dv;
                    if ($model->id_tipo_documento == 5){
                        $table->nombrecorto = strtoupper($model->razonsocial);
                        $model->nombrecliente = null;
                        $model->apellidocliente = null;
                    }else{
                        $table->nombrecorto = strtoupper($model->nombrecliente . " " . $model->apellidocliente);
                        $model->razonsocial = null;
                    } 
                    if ($table->save(false)) {
                        Yii::$app->getSession()->setFlash('success', 'Registro actualizado con exito.');
                        return $this->redirect(["clientes/index"]);
                    } else {
                        $this->redirect(["clientes/index"]);
                    }
                } else {
                    $msg = "El registro seleccionado no ha sido encontrado";
                    $tipomsg = "danger";
                }
            } else {
                $model->getErrors();
            }
        }


        if (Yii::$app->request->get("id")) {
            $table = Cliente::find()->where(['idcliente' => $id])->one();
            $municipio = Municipio::find()->Where(['=', 'iddepartamento', $table->iddepartamento])->all();
            $municipio = ArrayHelper::map($municipio, "idmunicipio", "municipio");
            if ($table) {
                $model->id_tipo_documento = $table->id_tipo_documento;
                $model->cedulanit = $table->cedulanit;
                $model->razonsocial = $table->razonsocial;
                $model->nombrecliente = $table->nombrecliente;
                $model->apellidocliente = $table->apellidocliente;
                $model->direccioncliente = $table->direccioncliente;
                $model->celularcliente = $table->celularcliente;
                $model->telefonocliente = $table->telefonocliente;
                $model->emailcliente = $table->emailcliente;
                $model->iddepartamento = $table->iddepartamento;
                $model->idmunicipio = $table->idmunicipio;
                $model->dv = $table->dv;
                $model->observacion = $table->observacion;
            } else {
                return $this->redirect(["clientes/index"]);
            }
        } else {
            return $this->redirect(["clientes/index"]);
        }
        return $this->render("update", ["model" => $model,  "municipio" => $municipio]);
    }

    public function actionView($id, $token) {
                
        $model = Cliente::find()->where(['idcliente' => $id])->one();
        $Concontacto = \app\models\ClientesContactos::find()->where(['=','id_cliente', $id])->all();
        $ConDireccion = \app\models\ClientesDirecciones::find()->where(['=','idcliente', $id])->all();
        return $this->render('view', ['model' => $model , 'token' => $token,
                          'Concontacto' => $Concontacto,
                          'ConDireccion' => $ConDireccion,
        ]);
    }

    public function actionEliminar($id) {
        if (Yii::$app->request->post()) {
            $cliente = Cliente::findOne($id);
            if ((int) $id) {
                try {
                    Cliente::deleteAll("idcliente=:idcliente", [":idcliente" => $id]);
                    Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
                    $this->redirect(["clientes/index"]);
                } catch (IntegrityException $e) {
                    $this->redirect(["clientes/index"]);
                    Yii::$app->getSession()->setFlash('error', 'Error al eliminar el cliente ' . $cliente->cedulanit - $cliente->nombrecorto . ' tiene registros asociados en otros procesos');
                } catch (\Exception $e) {

                    $this->redirect(["clientes/index"]);
                    Yii::$app->getSession()->setFlash('error', 'Error al eliminar el cliente ' . $cliente->cedulanit . '-' . $cliente->nombrecorto . ' tiene registros asociados en otros procesos');
                }
            } else {
                // echo "Ha ocurrido un error al eliminar el cliente, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("clientes/index") . "'>";
            }
        } else {
            return $this->redirect(["clientes/index"]);
        }
    }

    public function actionMunicipio($id) {
        $rows = Municipio::find()->where(['iddepartamento' => $id])->all();

        echo "<option required>Seleccione...</option>";
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                echo "<option value='$row->idmunicipio' required>$row->municipio</option>";
            }
        }
    }
    
    public function actionIndex_consulta($token = 1) {
        if (Yii::$app->user->identity){
        if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',11])->all()){
            $form = new FormFiltroConsultaCliente();
            $cedulanit = null;
            $nombrecorto = null;
            if ($form->load(Yii::$app->request->get())) {
                if ($form->validate()) {
                    $cedulanit = Html::encode($form->cedulanit);
                    $nombrecorto = Html::encode($form->nombrecorto);
                    $table = Cliente::find()
                            ->andFilterWhere(['=', 'cedulanit', $cedulanit])
                            ->andFilterWhere(['like', 'nombrecorto', $nombrecorto])
                            ->orderBy('idcliente desc');
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
                        //$table = $table->all();
                        $this->actionExcelDepartamento($tableexcel);
                    }
                } else {
                    $form->getErrors();
                }
            } else {
                $table = Cliente::find()
                        ->orderBy('idcliente desc');
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
                   $this->actionExcelDepartamento($tableexcel);
                }
            }
            $to = $count->count();
            return $this->render('search_consulta_clientes', [
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
    
    public function actionMunicipios($id) {
        $rows = Municipio::find()->where(['iddepartamento' => $id])->all();

        echo "<option required>Seleccione...</option>";
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                echo "<option value='$row->idmunicipio' required>$row->municipio</option>";
            }
        }
    }
    
    //CREA UN NUEVA DIRECCION DEL CLIENTE
    public function actionNew_direccion($id, $token) {

        $model = new \app\models\ModeloDireccionesCliente();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if (isset($_POST["nuevo_contacto_cliente"])) {
                    $table = new \app\models\ClientesDirecciones();
                    $table->idcliente = $id;
                    $table->iddepartamento = $model->iddepartamento;
                    $table->idmunicipio = $model->idmunicipio;
                    $table->nueva_direccion = strtoupper($model->direccion);
                    $table->user_name = Yii::$app->user->identity->username;
                    $table->save(false);
                    $this->redirect(["clientes/view", 'id' => $id,'token' => $token]);
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->renderAjax('form_nueva_direcciones', [
                    'model' => $model,
                    'id' => $id,
                    'token' => $token,
        ]);
    }
    
    //EDITAR LA UEVA DIRECCION DEL CLIENTE
    public function actionEditar_direccion($id, $token, $id_detalle) {
        
        $model = new \app\models\ModeloDireccionesCliente();
        
        $table = \app\models\ClientesDirecciones::findOne($id_detalle);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if (isset($_POST["nuevo_contacto_cliente"])) {
                    $table->iddepartamento = $model->iddepartamento;
                    $table->idmunicipio = $model->idmunicipio;
                    $table->nueva_direccion = strtoupper($model->direccion);
                    $table->save(false);
                    $this->redirect(["clientes/view", 'id' => $id,'token' => $token]);
                }
           } else {
                $model->getErrors();
            }
        }
        if (Yii::$app->request->get()) {
            $model->iddepartamento = $table->iddepartamento;
            $model->idmunicipio = $table->idmunicipio;
            $model->direccion = $table->nueva_direccion;
        }
        return $this->renderAjax('form_nueva_direcciones', [
                    'model' => $model,
                    'id' => $id,
                    'token' => $token,
        ]);
    }
    
    //CREA UN NUEVO CONTACTO DEL CLIENTE
    public function actionNew_contacto($id, $token) {

        $model = new \app\models\ModeloContactoCliente();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if (isset($_POST["nuevo_contacto_cliente"])) {
                    $table = new \app\models\ClientesContactos();
                    $table->id_cliente = $id;
                    $table->nombres = strtoupper($model->nombres);
                    $table->apellidos = strtoupper($model->apellidos);
                    $table->celular = $model->celular;
                    $table->email = $model->email;
                    $table->id_cargo = $model->cargo;
                    $table->fecha_nacimiento = $model->fecha_nacimiento;
                    $table->user_name = Yii::$app->user->identity->username;
                    $table->predeterminado = $model->predeterminado;
                    $table->save(false);
                    $this->redirect(["clientes/view", 'id' => $id,'token' => $token]);
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->renderAjax('form_nuevo_contacto', [
                    'model' => $model,
                    'id' => $id,
                    'token' => $token,
        ]);
    }
    
    //EDITAR CONTACTO
    public function actionEditar_contacto($id, $token, $detalle) {
        
        $model = new \app\models\ModeloContactoCliente();
        
        $table = \app\models\ClientesContactos::findOne($detalle);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if (isset($_POST["nuevo_contacto_cliente"])) {
                    $table->nombres = strtoupper($model->nombres);
                    $table->apellidos = strtoupper($model->apellidos);
                    $table->celular = $model->celular;
                    $table->email = $model->email;
                    $table->id_cargo = $model->cargo;
                    $table->fecha_nacimiento = $model->fecha_nacimiento;
                    $table->predeterminado = $model->predeterminado;
                    $table->save(false);
                    $this->redirect(["clientes/view", 'id' => $id,'token' => $token]);
                }
           } else {
                $model->getErrors();
            }
        }
        if (Yii::$app->request->get()) {
            $model->nombres = $table->nombres;
            $model->apellidos = $table->apellidos;
            $model->celular = $table->celular;
            $model->email = $table->email;
            $model->fecha_nacimiento = $table->fecha_nacimiento;
            $model->cargo = $table->id_cargo;
            $model->predeterminado = $table->predeterminado;
        }
        return $this->renderAjax('form_nuevo_contacto', [
                    'model' => $model,
                    'id' => $id,
                    'token' => $token,
        ]);
    }
    
    public function actionExcelDepartamento($tableexcel) {                
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
          
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'TIPO')
                    ->setCellValue('C1', 'DOCUMENTO')
                    ->setCellValue('D1', 'DV')
                    ->setCellValue('E1', 'RAZON SOCIAL')
                    ->setCellValue('F1', 'NOMBRES')
                    ->setCellValue('G1', 'APELLIDOS')
                    ->setCellValue('H1', 'RAZON SOCIAL')
                    ->setCellValue('I1', 'Departamento')
                    ->setCellValue('J1', 'Municipio')
                    ->setCellValue('K1', 'Direccion')
                    ->setCellValue('L1', 'Telefono')  
                    ->setCellValue('M1', 'celular')
                    ->setCellValue('N1', 'Email')
                    ->setCellValue('O1', 'Observacion');                    
        $i = 2;
        
        foreach ($tableexcel as $val) {
                                  
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val->idcliente)
                    ->setCellValue('B' . $i, $val->tipo->tipo)
                    ->setCellValue('D' . $i, $val->cedulanit)
                    ->setCellValue('E' . $i, $val->dv)
                    ->setCellValue('F' . $i, $val->razonsocial)
                    ->setCellValue('G' . $i, $val->nombrecliente)
                    ->setCellValue('H' . $i, $val->apellidocliente)
                    ->setCellValue('I' . $i, $val->nombrecorto)
                    ->setCellValue('J' . $i, $val->departamento->departamento)
                    ->setCellValue('K' . $i, $val->municipio->municipio)
                    ->setCellValue('L' . $i, $val->direccioncliente)
                    ->setCellValue('M' . $i, $val->telefonocliente)
                    ->setCellValue('N' . $i, $val->celularcliente)
                    ->setCellValue('O' . $i, $val->emailcliente)
                    ->setCellValue('V' . $i, $val->observacion);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('cliente');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="clientes.xlsx"');
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
