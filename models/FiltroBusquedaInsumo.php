<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FiltroBusquedaInsumo extends Model
{        
   
    public $codigo;
    public $insumo;
    public $medida;
    public $clasificacion;

    public function rules()
    {
        return [  
           [['codigo', 'medida','clasificacion'], 'integer'],
           [['insumo'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [   
            'codigo' => 'Codigo:',
            'insumo' => 'Nombre insumo:',
            'medida' => 'Tipo medida:',
            'clasificacion' => 'Clasificacion:',
         
       
        ];
    }
    
}

