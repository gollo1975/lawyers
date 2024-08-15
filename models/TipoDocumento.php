<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipodocumento".
 *
 * @property int $id_tipo_documento
 * @property string $tipo
 * @property string $descripcion
 * @property string $codigo_interfaz
 *
 * @property Cliente[] $clientes
 */
class Tipodocumento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipodocumento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'descripcion', 'codigo_interfaz'], 'required'],
            [['tipo', 'codigo_interfaz'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 40],
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
            'codigo_interfaz' => 'Codigo interfaz',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['id_tipo_documento' => 'id_tipo_documento']);
    }
}
