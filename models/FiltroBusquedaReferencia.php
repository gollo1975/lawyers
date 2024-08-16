<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FiltroBusquedaReferencia extends Model
{        
    public $codigo;
    public $referencia;
    public $grupo;


    public function rules()
    {
        return [            
            [['codigo','grupo'], 'integer'],
            [['referencia'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'codigo' => 'Código referencia:',                      
            'referencia' => 'Referencia:',
            'grupo' => 'Grupo:',
        ];
    }
}

    