<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ModeloPrecioVenta extends Model
{        
    public $nuevo_precio;


    public function rules()
    {
        return [            
            [['nuevo_precio'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'Nuevo_precio' => 'Precio de venta:',                      
        ];
    }
}

    