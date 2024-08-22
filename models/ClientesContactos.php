<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clientes_contactos".
 *
 * @property int $id_contacto
 * @property int $id_cliente
 * @property string $nombres
 * @property string $apelidos
 * @property string $email
 * @property int $id_cargo
 * @property string $fecha_nacimiento
 * @property string $user_name
 * @property string $fecha_registro
 *
 * @property Cliente $cliente
 * @property Cargos $cargo
 */
class ClientesContactos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes_contactos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cliente', 'id_cargo'], 'integer'],
            [['nombres', 'apellidos', 'id_cargo','celular'], 'required'],
            [['fecha_nacimiento', 'fecha_registro'], 'safe'],
            [['nombres', 'apelidos'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['user_name'], 'string', 'max' => 15],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['id_cliente' => 'idcliente']],
            [['id_cargo'], 'exist', 'skipOnError' => true, 'targetClass' => Cargos::className(), 'targetAttribute' => ['id_cargo' => 'id_cargo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_contacto' => 'Id Contacto',
            'id_cliente' => 'Id Cliente',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'email' => 'Email',
            'celular'=> 'Celular:',
            'id_cargo' => 'Id Cargo',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'user_name' => 'User Name',
            'fecha_registro' => 'Fecha Registro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['idcliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo()
    {
        return $this->hasOne(Cargos::className(), ['id_cargo' => 'id_cargo']);
    }
}
