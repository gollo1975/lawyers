<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormRecibocajanuevodetallelibre extends Model
{    
    public $vlrabono;        
    
    public function rules()
    {
        return [            
            [['vlrabono'], 'required'],            
            [['vlrabono'], 'number'],                       
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'vlrabono' => 'Valor Pago:',            
        ];
    }
    
}
