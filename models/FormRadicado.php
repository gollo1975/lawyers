<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormRadicado extends Model
{
    public $nro_demanda;    
    public $radicado;


    public function rules()
    {
        return [

            [['nro_demanda'], 'integer'],            
            [['radicado'], 'string'],            
        ];
    }

    public function attributeLabels()
    {
        return [
            'nro_demanda' => 'No demanda:',            
            'radicado' => 'Nro radicado:',
        ];
    }
}
