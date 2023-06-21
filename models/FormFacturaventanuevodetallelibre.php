<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFacturaventanuevodetallelibre extends Model
{    
    public $valor;
    public $idproducto;
    
    public function rules()
    {
        return [            
            [['valor','idproducto'], 'required'],            
            [['idproducto','valor'], 'number'],                       
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'valor' => 'Valor:',   
            'idproducto' => 'Producto:',   
        ];
    }
    
}
