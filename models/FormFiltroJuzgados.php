<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroJuzgados extends Model
{
    public $id_departamento;
    public $id_municipio;
    public $codigo;
    public $distrito;
    public $circuito;
    public $id_area;
    public $id_juez;
    public $jurisdiccion;
    public $nombre_juzgado;
        
    public function rules()
    {
        return [

            [['codigo', 'distrito','id_area','circuito','id_juez','jurisdiccion'], 'integer'],
            [['id_departamento','id_municipio','nombre_juzgado'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [

            'id_departamento' => 'Departamento:',
            'id_municipio' => 'Municipio:',
            'codigo' => 'Código juzgado:',
            'distrito' => 'Distrito:',
            'circuito' => 'Circuito:',
            'id_area' => 'Area:',
            'nombre_juzgado' => 'Juzgado:',
            'jurisdiccion' => 'Jurisdicción',
            'id_juez' => 'Juez:',
        ];
    }
}
