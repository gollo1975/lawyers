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
    public $cantidad; 
    public $grupo;
    public $homologado;
    public $ficha;


    public function rules()
    {
        return [            
            [['clasificacion','cantidad','grupo'], 'integer'],
            [['referencia','q','nota','codigo','homologado','ficha'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'clasificacion' => 'Clasificacion:',   
            'referencia' => 'Referencia:',
            'q' => 'Talla:',
            'nota' => 'Nota:',
            'codigo' => 'Codigo referencia:',
            'cantidad' => 'Cantidades:',
            'grupo' => 'Grupo:',
            'homologado' => 'Codigo homologado:',
            'ficha' => 'Ficha tecnica:',
        ];
    }
}

    