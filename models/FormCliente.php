<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Cliente;
use app\models\Departamentos;
use app\models\Municipio;

/**
 * ContactForm is the model behind the contact form.
 */
class FormCliente extends Model
{
    public $idcliente;
    public $id_tipo_documento;
    public $cedulanit;
    public $dv;
    public $razonsocial;
    public $nombrecliente;
    public $apellidocliente;
    public $nombrecorto;
    public $direccioncliente;
    public $telefonocliente;
    public $celularcliente;
    public $emailcliente;
    public $iddepartamento;
    public $idmunicipio;
    public $nitmatricula;
    public $observacion;
    public $fechaingreso;
    public $usuario;

    public function rules()
    {
        return [
			
            ['id_tipo_documento', 'required', 'message' => 'Campo requerido'],
            ['cedulanit', 'required', 'message' => 'Campo requerido'],
            ['cedulanit', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['cedulanit', 'cedulanit_existe'],            
            [['dv'], 'string', 'max' => 1],
            ['razonsocial', 'match', 'pattern' => '/^[.-0-9a-záéíóúñ\s ]+$/i', 'message' => 'Sólo se aceptan letras'],
            ['nombrecliente', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
            ['apellidocliente', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
            ['apellidocliente', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
            ['direccioncliente', 'default'],
            ['telefonocliente', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['celularcliente', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['emailcliente', 'email'],
            [['emailcliente', 'direccioncliente','celularcliente'], 'required', 'message' => 'Campo requerido'],
            ['emailcliente', 'email_existe'],
            ['iddepartamento', 'required', 'message' => 'Campo requerido'],
            ['idmunicipio', 'required', 'message' => 'Campo requerido'],
            [['idmunicipio'], 'exist', 'skipOnError' => true, 'targetClass' => Municipio::className(), 'targetAttribute' => ['idmunicipio' => 'idmunicipio'],'message' => 'Campo requerido'],                      
            ['observacion', 'default'],
            ['usuario', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_tipo_documento' => 'Tipo Identificacion:',
            'cedulanit' => 'Cedula/Nit:',
            'razonsocial' => 'Razón Social:',
            'nombrecliente' => 'Nombres:',
            'apellidocliente' => 'Apellidos:',
            'direccioncliente' => 'Dirección:',
            'telefonocliente' => 'Teléfono:',
            'celularcliente' => 'celular:',
            'emailcliente' => 'Email:',
            'iddepartamento' => 'Departamento:',
            'idmunicipio' => 'Municipio:',            
            'dv' => '',
            'observacion' => 'Observaciones:',
            'usuario' => 'Usuario:',
           

        ];
    }

    public function cedulanit_existe($attribute, $params)
    {
        //Buscar la cedula/nit en la tabla
        $table = Cliente::find()->where("cedulanit=:cedulanit", [":cedulanit" => $this->cedulanit])->andWhere("emailcliente!=:emailcliente", [':emailcliente' => $this->emailcliente]);
        //Si la identificacion existe mostrar el error
        if ($table->count() == 1)
        {
            $this->addError($attribute, "El número de identificación ya existe");
        }
    }   

    public function email_existe($attribute, $params)
    {
        //Buscar el email en la tabla
        $table = Cliente::find()->where("emailcliente=:emailcliente", [":emailcliente" => $this->emailcliente])->andWhere("cedulanit!=:cedulanit", [':cedulanit' => $this->cedulanit]);
        //Si el email existe mostrar el error
        if ($table->count() == 1)
        {
            $this->addError($attribute, "El email ya existe");
        }
    }
}
