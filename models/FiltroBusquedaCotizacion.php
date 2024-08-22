<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FiltroBusquedaCotizacion extends Model
{        
    public $numero;
    public $cliente;
    public $fecha_inicio;
    public $fecha_corte;
    public $grupo;
    public $referencia;
    public $codigo;


    public function rules()
    {
        return [            
            [['numero','cliente','grupo','codigo'], 'integer'],
            [['fecha_inicio','fecha_corte'], 'safe'],
            [['referencia'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'numero' => 'Numero cotizacion:',                      
            'cliente' => 'Cliente:',
            'fecha_inicio' => 'Fecha inicio:',
            'fecha_inicio' => 'Fecha corte:',
            'grupo' => 'Grupo referencia:',
            'codigo' => 'Codigo referencia',
            'referencia' => 'Referencia:',
        ];
    }
}

    