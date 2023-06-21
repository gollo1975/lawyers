<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormCompraBuscar extends Model
{
    public $factura;    
    public $id_proveedor;    

    public function rules()
    {
        return [

            [['id_proveedor'],'integer'],            
            [['factura'],'string'],            
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_proveedor' => 'Proveedor:',            
            'factura' => 'Documento:',
        ];
    }
}
