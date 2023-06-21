<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroContabilizar extends Model
{
    public $proceso;
    public $desde;
    public $hasta;    
    
    public function rules()
    {
        return [
            [['proceso','desde','hasta'], 'required', 'message' => 'Campo requerido'],
            ['proceso', 'match', 'pattern' => '/^[0-9a-z\s]+$/i', 'message' => 'Sólo se aceptan letras y números'],
            ['desde', 'safe'],
            ['hasta', 'safe'],            
        ];
    }

    public function attributeLabels()
    {
        return [
            'proceso' => 'Proceso:',            
            'desde' => 'Desde:',
            'hasta' => 'Hasta:',            
        ];
    }
}
