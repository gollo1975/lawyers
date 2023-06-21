<?php

namespace app\controllers;

use app\models\Juzgados;
use app\models\JuzgadosSearch;
use app\models\FormFiltroJuzgados;
use app\models\UsuarioDetalle;
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

/**
 * JuzgadosController implements the CRUD actions for Juzgados model.
 */
class JuzgadosController extends Controller
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
     * Lists all Juzgados models.
     * @return mixed
     */
     public function actionIndex() {
        if (Yii::$app->user->identity){
        if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',6])->all()){
            $form = new FormFiltroJuzgados();
            $id_departamento = null;
            $id_municipio = null;
            $codigo = null;
            $distrito = null;
            $circuito = null;
            $id_area = null;
            $id_juez = null;
            $jurisdiccion = null;
            $nombre_juzgado = null;
            if ($form->load(Yii::$app->request->get())) {
                if ($form->validate()) {
                    $id_departamento = Html::encode($form->id_departamento);
                    $id_municipio = Html::encode($form->id_municipio);
                    $codigo = Html::encode($form->codigo);
                    $distrito = Html::encode($form->distrito);
                    $circuito = Html::encode($form->circuito);;
                    $id_area = Html::encode($form->id_area);
                    $id_juez = Html::encode($form->id_juez);
                    $jurisdiccion = Html::encode($form->jurisdiccion);
                    $nombre_juzgado = Html::encode($form->nombre_juzgado);
                    $table = Juzgados::find()
                            ->andFilterWhere(['=', 'iddepartamento', $id_departamento])
                            ->andFilterWhere(['=', 'idmunicipio', $id_municipio])
                            ->andFilterWhere(['=', 'codigo_juzgado', $codigo])
                            ->andFilterWhere(['=', 'id_distrito', $distrito])
                            ->andFilterWhere(['=', 'id_circuito', $circuito])
                            ->andFilterWhere(['=', 'id_area_juzgado', $id_area])
                            ->andFilterWhere(['=', 'id_juez', $id_juez])
                            ->andFilterWhere(['=', 'id_jurisdiccion', $jurisdiccion])
                            ->andFilterWhere(['like', 'nombre_juzgado', $nombre_juzgado]);
                    $table = $table->orderBy('codigo_juzgado desc');
                    $tableexcel = $table->all();
                    $count = clone $table;
                    $to = $count->count();
                    $pages = new Pagination([
                        'pageSize' => 30,
                        'totalCount' => $count->count()
                    ]);
                    $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
                    if(isset($_POST['excel'])){
                        //$table = $table->all();
                        $this->actionExcelconsultaJuzgados($tableexcel);
                    }
                } else {
                    $form->getErrors();
                }
            } else {
                $table = Juzgados::find()
                        ->orderBy('codigo_juzgado desc');
                $tableexcel = $table->all();
                $count = clone $table;
                $pages = new Pagination([
                    'pageSize' => 30,
                    'totalCount' => $count->count(),
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                if(isset($_POST['excel'])){
                    //$table = $table->all();
                    $this->actionExcelconsultaJuzgados($tableexcel);
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
     * Displays a single Juzgados model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Juzgados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($token = 0)
    {
        $model = new Juzgados();
         if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {           
            if ($model->validate()) {
               $table = new Juzgados();
               $table->codigo_juzgado = $model->codigo_juzgado;
               $table->nombre_juzgado = $model->nombre_juzgado;
               $table->direccion_juzgado = $model->direccion_juzgado;
               $table->telefono_juzgado = $model->telefono_juzgado;
               $table->celular_juzgado = $model->celular_juzgado;
               $table->email_juzgado = $model->email_juzgado;
               $table->iddepartamento = $model->iddepartamento;
               $table->idmunicipio = $model->idmunicipio;
               $table->id_distrito = $model->id_distrito;
               $table->id_circuito = $model->id_circuito;
               $table->id_jurisdiccion = $model->id_jurisdiccion;
               $table->id_area_juzgado = $model->id_area_juzgado;
               $table->id_juez = $model->id_juez;
               $table->usuario = Yii::$app->user->identity->username;
               $table->fecha_registro = date('Y-m-d');
               $table->save(false);
               return $this->redirect(["juzgados/index"]);
            }
        }    
        return $this->render('create', [
            'model' => $model,
            'token' => $token,
        ]);
    }

    /**
     * Updates an existing Juzgados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $token = 1)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $juzgado = Juzgados::findOne($id);
            if($juzgado){
                $juzgado->nombre_juzgado = $model->nombre_juzgado;
                $juzgado->direccion_juzgado = $model->direccion_juzgado;
                $juzgado->telefono_juzgado = $model->telefono_juzgado;
                $juzgado->celular_juzgado = $model->celular_juzgado;
                $juzgado->email_juzgado = $model->email_juzgado;
                $juzgado->iddepartamento = $model->iddepartamento;
                $juzgado->idmunicipio = $model->idmunicipio;
                $juzgado->id_distrito = $model->id_distrito;
                $juzgado->id_circuito = $model->id_circuito;
                $juzgado->id_jurisdiccion = $model->id_jurisdiccion;
                $juzgado->id_area_juzgado = $model->id_area_juzgado;
                $juzgado->id_juez = $model->id_juez;
                $juzgado->estado_registro = $model->estado_registro;
                $juzgado->save(false);
                return $this->redirect(['index']);
            }
        }
        if (Yii::$app->request->get("id")) {
             $table = Juzgados::find()->where(['codigo_juzgado' => $id])->one();
            if ($table) {     

                $model->nombre_juzgado = $table->nombre_juzgado;
                $model->direccion_juzgado = $table->direccion_juzgado;
                $model->telefono_juzgado = $table->telefono_juzgado;
                $model->celular_juzgado = $table->celular_juzgado;
                $model->email_juzgado = $table->email_juzgado;
                $model->iddepartamento = $table->iddepartamento;
                $model->idmunicipio = $table->idmunicipio;
                $model->id_distrito = $table->id_distrito;
                $model->id_circuito = $table->id_circuito;
                $model->id_jurisdiccion = $table->id_jurisdiccion;
                $model->id_area_juzgado = $table->id_area_juzgado;
                $model->id_juez = $table->id_juez;
                $model->estado_registro = $table->estado_registro;
           }else{
                return $this->redirect(['index']);
           }
        }
        return $this->render('update', [
            'model' => $model,
            'token' => $token,
        ]);
    }

  

    /**
     * Finds the Juzgados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Juzgados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Juzgados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    //EXPORTARA EXCEL
    
     public function actionExcelconsultaJuzgados($tableexcel) {                
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
                              
        $objPHPExcel->setActiveSheetIndex(0)
                     ->setCellValue('A1', 'CODIGO')
                    ->setCellValue('B1', 'JUZGADO')
                    ->setCellValue('C1', 'DIRECCION')
                    ->setCellValue('D1', 'TELEFONO')
                    ->setCellValue('E1', 'EMAIL')
                    ->setCellValue('F1', 'CELULAR')
                    ->setCellValue('G1', 'DEPARTAMENTO')                    
                    ->setCellValue('H1', 'MUNICIPIO')
                    ->setCellValue('I1', 'CIRCUITO')
                    ->setCellValue('J1', 'DISTRITO')
                    ->setCellValue('K1', 'JURISDICCION')
                    ->setCellValue('L1', 'AREA')
                    ->setCellValue('M1', 'JUEZ')
                    ->setCellValue('N1', 'USUARIO')
                    ->setCellValue('O1', 'FECHA REGISTRO')
                    ->setCellValue('P1', 'ACTIVO');
                   
        $i = 2  ;
        
        foreach ($tableexcel as $val) {
                                  
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val->codigo_juzgado)
                    ->setCellValue('B' . $i, $val->nombre_juzgado)
                    ->setCellValue('C' . $i, $val->direccion_juzgado)
                    ->setCellValue('D' . $i, $val->telefono_juzgado)
                    ->setCellValue('E' . $i, $val->email_juzgado)
                    ->setCellValue('F' . $i, $val->celular_juzgado)
                    ->setCellValue('G' . $i, $val->departamento->departamento)                    
                    ->setCellValue('H' . $i, $val->municipio->municipio)
                    ->setCellValue('I' . $i, $val->circuito->nombre_circuito)
                    ->setCellValue('J' . $i, $val->distrito->nombre_distrito)
                    ->setCellValue('K' . $i, $val->jurisdiccion->jurisdiccion)
                    ->setCellValue('L' . $i, $val->areaJuzgado->area)
                    ->setCellValue('M' . $i, $val->juez->nombre_juez)
                    ->setCellValue('N' . $i, $val->usuario)
                    ->setCellValue('O' . $i, $val->fecha_registro)
                    ->setCellValue('P' . $i, $val->activo);
                   
            $i++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Juzgados');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Juzgados.xlsx"');
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
