<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cargos".
 *
 * @property int $id_cargo
 * @property string $cargo
 *
 * @property ClientesContactos[] $clientesContactos
 */
class Cargos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cargos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cargo'], 'required'],
            [['cargo'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cargo' => 'Id Cargo',
            'cargo' => 'Cargo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesContactos()
    {
        return $this->hasMany(ClientesContactos::className(), ['id_cargo' => 'id_cargo']);
    }
}
