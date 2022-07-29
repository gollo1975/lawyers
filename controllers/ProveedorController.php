<?php

namespace app\controllers;

use app\models\Ordenproduccion;
use Codeception\Lib\HelperModule;
use yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Proveedor;
use app\models\Municipio;
use app\models\Departamentos;
use app\models\FormProveedor;
use yii\helpers\Url;
use app\models\FormFiltroProveedor;
use yii\web\UploadedFile;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\UsuarioDetalle;


class ProveedorController extends Controller {

    public function actionIndex() {
        if (Yii::$app->user->identity){
            if (UsuarioDetalle::find()->where(['=','codusuario', Yii::$app->user->identity->codusuario])->andWhere(['=','id_permiso',15])->all()){
                $form = new FormFiltroProveedor;
                $cedulanit = null;
                $nombrecorto = null;
                if ($form->load(Yii::$app->request->get())) {
                    if ($form->validate()) {
                        $cedulanit = Html::encode($form->cedulanit);
                        $nombrecorto = Html::encode($form->nombrecorto);
                        $table = proveedor::find()
                                ->andFilterWhere(['like', 'cedulanit', $cedulanit])
                                ->andFilterWhere(['like', 'nombrecorto', $nombrecorto])
                                ->orderBy('idproveedor desc');
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
                } else {
                    $table = Proveedor::find()
                            ->orderBy('idproveedor desc');
                    $count = clone $table;
                    $pages = new Pagination([
                        'pageSize' => 10,
                        'totalCount' => $count->count(),
                    ]);
                    $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
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

    public function actionNuevo() {
        $model = new FormProveedor();
        $msg = null;
        $tipomsg = null;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $dv = Html::encode($_POST["dv"]);
            if ($model->validate()) {
                $table = new proveedor();
                $table->id_tipo_documento = $model->id_tipo_documento;
                $table->cedulanit = $model->cedulanit;
                $table->razonsocial = $model->razonsocial;
                $table->nombreproveedor = $model->nombreproveedor;
                $table->apellidoproveedor = $model->apellidoproveedor;
                $table->direccionproveedor = $model->direccionproveedor;
                $table->telefonoproveedor = $model->telefonoproveedor;
                $table->celularproveedor = $model->celularproveedor;
                $table->emailproveedor = $model->emailproveedor;
                $table->iddepartamento = $model->iddepartamento;
                $table->idmunicipio = $model->idmunicipio;
                $table->contacto = $model->contacto;
                $table->telefonocontacto = $model->telefonocontacto;
                $table->celularcontacto = $model->celularcontacto;
                $table->formapago = $model->formapago;
                $table->plazopago = $model->plazopago;
                $table->nitmatricula = $model->cedulanit;
                $table->tiporegimen = $model->tiporegimen;
                $table->autoretenedor = $model->autoretenedor;
                $table->naturaleza = $model->naturaleza;
                $table->sociedad = $model->sociedad;
                $table->observacion = $model->observacion;
                $table->dv = $dv;
                $table->banco = $model->banco;
                $table->tipocuenta = $model->tipocuenta;
                $table->cuentanumero = $model->cuentanumero;
                $table->genera_moda = $model->genera_moda;
                if ($model->id_tipo_documento == 1) {
                    $table->nombrecorto = $model->nombreproveedor . " " . $model->apellidoproveedor;
                    $model->razonsocial = null;
                } elseif ($model->id_tipo_documento == 5) {
                    $table->nombrecorto = $model->razonsocial;
                    $model->nombreproveedor = null;
                    $model->apellidoproveedor = null;
                }

                if ($table->insert()) {
                    return $this->redirect(['index']);
                } else {
                    $msg = "error";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render('nuevo', ['model' => $model, 'msg' => $msg, 'tipomsg' => $tipomsg]);
    }

    public function actionEditar($id) {
        $model = new FormProveedor();
        $msg = null;
        $tipomsg = null;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $dv = Html::encode($_POST["dv"]);
            if ($model->validate()) {
                $table = Proveedor::find()->where(['idproveedor' => $id])->one();
                if ($table) {
                    $table->id_tipo_documento = $model->id_tipo_documento;
                    $table->cedulanit = $model->cedulanit;
                    $table->razonsocial = $model->razonsocial;
                    $table->nombreproveedor = $model->nombreproveedor;
                    $table->apellidoproveedor = $model->apellidoproveedor;
                    $table->direccionproveedor = $model->direccionproveedor;
                    $table->telefonoproveedor = $model->telefonoproveedor;
                    $table->celularproveedor = $model->celularproveedor;
                    $table->emailproveedor = $model->emailproveedor;
                    $table->iddepartamento = $model->iddepartamento;
                    $table->idmunicipio = $model->idmunicipio;
                    $table->contacto = $model->contacto;
                    $table->telefonocontacto = $model->telefonocontacto;
                    $table->celularcontacto = $model->celularcontacto;
                    $table->formapago = $model->formapago;
                    $table->plazopago = $model->plazopago;
                    $table->nitmatricula = $model->cedulanit;
                    $table->tiporegimen = $model->tiporegimen;
                    $table->autoretenedor = $model->autoretenedor;
                    $table->sociedad = $model->sociedad;
                    $table->naturaleza = $model->naturaleza;
                    $table->observacion = $model->observacion;
                    $table->banco = $model->banco;
                    $table->tipocuenta = $model->tipocuenta;
                    $table->cuentanumero = $model->cuentanumero;
                    $table->genera_moda = $model->genera_moda;
                    if ($model->id_tipo_documento == 1) {
                        $table->nombrecorto = strtoupper($model->nombreproveedor . " " . $model->apellidoproveedor);
                        $model->razonsocial = null;
                    } elseif ($model->id_tipo_documento == 5) {
                        $table->nombrecorto = strtoupper($model->razonsocial);
                        $model->nombreproveedor = null;
                        $model->apellidoproveedor = null;
                    }
                    if ($table->update()) {
                        $msg = "El registro ha sido actualizado correctamente";
                        return $this->redirect(['index']);
                    } else {
                        $msg = "El registro no sufrio ningun cambio";
                        $tipomsg = "danger";
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
            $table = Proveedor::find()->where(['idproveedor' => $id])->one();
            $municipio = Municipio::find()->Where(['=', 'iddepartamento', $table->iddepartamento])->all();
            $municipio = ArrayHelper::map($municipio, "idmunicipio", "municipio");
            if ($table) {
                $model->id_tipo_documento = $table->id_tipo_documento;
                $model->cedulanit = $table->cedulanit;
                $model->razonsocial = $table->razonsocial;
                $model->nombreproveedor = $table->nombreproveedor;
                $model->apellidoproveedor = $table->apellidoproveedor;
                $model->direccionproveedor = $table->direccionproveedor;
                $model->telefonoproveedor = $table->telefonoproveedor;
                $model->celularproveedor = $table->celularproveedor;
                $model->emailproveedor = $table->emailproveedor;
                $model->iddepartamento = $table->iddepartamento;
                $model->idmunicipio = $table->idmunicipio;
                $model->contacto = $table->contacto;
                $model->telefonocontacto = $table->telefonocontacto;
                $model->celularcontacto = $table->celularcontacto;
                $model->formapago = $table->formapago;
                $model->plazopago = $table->plazopago;
                $model->nitmatricula = $table->nitmatricula;
                $model->tiporegimen = $table->tiporegimen;
                $model->autoretenedor = $table->autoretenedor;
                $model->naturaleza = $table->naturaleza;
                $model->sociedad = $table->sociedad;
                $model->dv = $table->dv;
                $model->observacion = $table->observacion;
                $model->banco = $table->banco;
                $model->tipocuenta = $table->tipocuenta;
                $model->cuentanumero = $table->cuentanumero;
                $model->genera_moda = $table->genera_moda;
            } else {
                return $this->redirect(["proveedor/index"]);
            }
        } else {
            return $this->redirect(["proveedor/index"]);
        }
        return $this->render("editar", ["model" => $model, "msg" => $msg, "tipomsg" => $tipomsg, "municipio" => $municipio]);
    }

    public function actionView($id) {
        // $model = new List();            
        $table = Proveedor::find()->where(['idproveedor' => $id])->one();
        return $this->render('view', ['table' => $table
        ]);
    }

    public function actionEliminar($id) {
        if (Yii::$app->request->post()) {
            $proveedor = Proveedor::findOne($id);
            if ((int) $id) {
                try {
                    proveedor::deleteAll("idproveedor=:idproveedor", [":idproveedor" => $id]);
                    Yii::$app->getSession()->setFlash('success', 'Registro Eliminado.');
                    $this->redirect(["proveedor/index"]);
                } catch (IntegrityException $e) {
                    $this->redirect(["proveedor/index"]);
                    Yii::$app->getSession()->setFlash('error', 'Error al eliminar el proveedor ' . $proveedor->cedulanit - $proveedor->nombrecorto . ' tiene registros asociados en otros procesos');
                } catch (\Exception $e) {

                    $this->redirect(["proveedor/index"]);
                    Yii::$app->getSession()->setFlash('error', 'Error al eliminar el proveedor ' . $proveedor->cedulanit . '-' . $proveedor->nombrecorto . ' tiene registros asociados en otros procesos');
                }
            } else {
                // echo "Ha ocurrido un error al eliminar el proveedor, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("proveedor/index") . "'>";
            }
        } else {
            return $this->redirect(["proveedor/index"]);
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

}
