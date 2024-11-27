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
    public $homologado;
    public $estado;
    public $nota_comercial;
    public $nota_ficha;


    public function rules()
    {
        return [            
            [['codigo','grupo','estado'], 'integer'],
            [['referencia','homologado','nota_comercial','nota_ficha'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'codigo' => 'Código referencia:',                      
            'referencia' => 'Referencia:',
            'grupo' => 'Grupo:',
            'homologado' => 'Codigo homologado:',
            'estado' => 'Registro activo:',
            'nota_ficha' => 'Ficha tecnica:',
            'nota_comercial' => 'Nota comercial:',
        ];
    }
}

    