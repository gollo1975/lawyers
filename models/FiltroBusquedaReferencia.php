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


    public function rules()
    {
        return [            
            [['codigo','grupo','estado'], 'integer'],
            [['referencia','homologado'], 'string'],
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
        ];
    }
}

    