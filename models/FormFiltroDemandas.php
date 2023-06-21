<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroDemandas extends Model
{
    public $nro_demanda;
    public $idcliente;
    public $id_especialidad;
    public $documento;
    public $documento_demandado;
    public $id_clase_demanda;
    public $codigo_juzgado;
    public $desde;
    public $hasta;
        
    public function rules()
    {
        return [

            [['idcliente','id_especialidad','id_clase_demanda'], 'integer'],
            [['documento','documento_demandado','codigo_juzgado'], 'string'],
            [['desde','hasta'],'safe'],
             ['nro_demanda', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
        ];
    }

    public function attributeLabels()
    {
        return [

            'nro_demanda' => 'Nro:',
            'idcliente' => 'Cliente:',
            'id_especialidad' => 'Especialidad:',
            'id_clase_demanda' => 'Tipo proceso:',
            'documento' => 'Abogado:',
            'documento_demandado' => 'Demandado:',
            'codigo_juzgado' => 'Juzgado:',
            'desde' => 'Desde',
            'hasta' => 'Hasta:',
        ];
    }
}
