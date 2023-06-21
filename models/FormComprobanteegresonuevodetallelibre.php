<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormComprobanteegresonuevodetallelibre extends Model
{    
    public $vlr_abono;
    public $subtotal;
    public $iva;
    public $retefuente;
    public $reteiva;
    public $base_aiu;
    
    public function rules()
    {
        return [            
            [['vlr_abono','subtotal','iva','retefuente','reteiva','base_aiu'], 'required'],            
            [['vlr_abono','subtotal','iva','retefuente','reteiva','base_aiu'], 'number'],                       
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'vlr_abono' => 'Valor Pago:',
            'subtotal' => 'Subtotal:',
            'iva' => 'Iva:',
            'retefuente' => 'Rete Fuente:',
            'reteiva' => 'Rete Iva:',
            'base_aiu' => 'Base Aiu:',
        ];
    }
    
}
