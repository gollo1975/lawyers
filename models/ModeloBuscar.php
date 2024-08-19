<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ModeloBuscar extends Model
{        
    public $nombre_insumo;
    public $referencia;
    public $clasificacion;
    public $q;
    public $nota;
    public $codigo;


    public function rules()
    {
        return [            
            [['clasificacion'], 'integer'],
            [['referencia','q','nota','codigo'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'clasificacion' => 'Clasificacion:',   
            'referencia' => 'Referencia:',
            'q' => 'Talla:',
            'nota' => 'Nota(200):',
            'codigo' => 'Codigo referencia:',
        ];
    }
}

    