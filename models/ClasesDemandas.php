<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clases_demandas".
 *
 * @property int $id_clase_demanda
 * @property string $concepto
 * @property string $usuario
 * @property string $fecha_creacion
 */
class ClasesDemandas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clases_demandas';
    }
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->concepto = strtoupper($this->concepto);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['concepto'], 'required'],
            [['fecha_creacion'], 'safe'],
            [['concepto'], 'string', 'max' => 50],
            [['usuario'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_clase_demanda' => 'Código',
            'concepto' => 'Concepto',
            'usuario' => 'Usuario',
            'fecha_creacion' => 'Fecha creacion',
        ];
    }
}
