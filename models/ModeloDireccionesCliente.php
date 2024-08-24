<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
//ESTE PROCESO SIRVE PARA EL CUPO AL CLIENTE Y EL NUEVO PRECIO DE VENTA PARA INVENTARIO DIRECTO
class ModeloDireccionesCliente extends Model
{
    public $iddepartamento;
    public $idmunicipio;
    public $direccion;

    public function rules()
    {
        return [

           [['iddepartamento','idmunicipio'], 'required', 'message' => 'Campo requerido'], 
           [['iddepartamento','idmunicipio','direccion'], 'string'],
            [['direccion'], 'string' , 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'iddepartamento' => 'Departamento:',
            'idmunicipio' => 'Municipio:',
            'direccion' => 'Nueva dirección:',
          

        ];
    }
}
