<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipodocumento".
 *
 * @property int $id_tipo_documento
 * @property string $tipo
 * @property string $descripcion
 *
 * @property Cliente[] $clientes
 */
class TipoDocumento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipodocumento';
    }

    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)){
            return false;
        }	       
        $this->descripcion = strtoupper($this->descripcion);
        $this->tipo = strtoupper($this->tipo);
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'descripcion','codigo_interfaz'], 'required', 'message' => 'Campo requerido'],
            [['tipo','codigo_interfaz'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 40],
            [['vista_cliente','vista_abogados','vista_demandados'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_documento' => 'Id',
            'tipo' => 'Tipo',
            'descripcion' => 'Descripcion',
            'codigo_interfaz' => 'Código Interfaz',
            'vista_cliente' => 'Vista cliente',
            'vista_abogados' => 'Vista_abogados',
            'vista_demandados' => 'Vista demandados',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['id_tipo_documento' => 'id_tipo_documento']);
    }
    
    public function getEmpleado()
    {
        return $this->hasMany(Empleado::className(), ['id_tipo_documento' => 'id_tipo_documento']);
    }
}
