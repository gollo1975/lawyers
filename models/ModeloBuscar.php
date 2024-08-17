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
    public $clasificacion;


    public function rules()
    {
        return [            
            [['clasificacion'], 'integer'],
            [['nombre_insumo'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'clasificacion' => 'Clasificacion:',   
            'nombre_insumo' => 'Nombre insumo:',
        ];
    }
}

    