<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tiporecibo".
 *
 * @property string $idtiporecibo
 * @property string $concepto
 * @property int $activo
 */
class TipoRecibo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiporecibo';
    }
	
    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)){
            return false;
        }	       
        $this->concepto = strtoupper($this->concepto);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['concepto'], 'required', 'message' => 'Campo requerido'],
            ['idtiporecibo', 'default'],            
            [['activo'], 'integer'],            
            [['concepto'], 'string', 'max' => 30],            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [            
            'concepto' => 'Concepto',
            'activo' => 'Activo',
            'idtiporecibo' => 'Id',
        ];
    }
    
    public function getEstado()
    {
        if($this->activo == 1){
            $estado = "SI";
        }else{
            $estado = "NO";
        }
        return $estado;
    }
}
