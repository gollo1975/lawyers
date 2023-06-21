<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "especialidades".
 *
 * @property int $id_especialidad
 * @property int $especialidad
 * @property string $fecha_proceso
 * @property string $usuario
 */
class Especialidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'especialidades';
    }
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->especialidad = strtoupper($this->especialidad); 
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['especialidad'], 'required'],
            [['especialidad'], 'string', 'max' => 30],
            [['fecha_proceso'], 'safe'],
            [['usuario'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_especialidad' => 'Código',
            'especialidad' => 'Especialidad',
            'fecha_proceso' => 'Fecha proceso',
            'usuario' => 'Usuario',
        ];
    }
}
