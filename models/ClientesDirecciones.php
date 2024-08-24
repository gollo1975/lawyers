<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clientes_direcciones".
 *
 * @property int $id_direccion
 * @property int $idcliente
 * @property string $iddepartamento
 * @property string $idmunicipio
 * @property string $nueva_direccion
 * @property string $fecha_registro
 * @property string $user_name
 *
 * @property Cliente $cliente
 */
class ClientesDirecciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes_direcciones';
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcliente', 'iddepartamento', 'idmunicipio'], 'required'],
            [['idcliente'], 'integer'],
            [['fecha_registro'], 'safe'],
            [['iddepartamento', 'idmunicipio', 'user_name'], 'string', 'max' => 15],
            [['nueva_direccion'], 'string', 'max' => 50],
            [['idcliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['idcliente' => 'idcliente']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_direccion' => 'Id Direccion',
            'idcliente' => 'Idcliente',
            'iddepartamento' => 'Iddepartamento',
            'idmunicipio' => 'Idmunicipio',
            'nueva_direccion' => 'Nueva Direccion',
            'fecha_registro' => 'Fecha Registro',
            'user_name' => 'User Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['idcliente' => 'idcliente']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['iddepartamento' => 'iddepartamento']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['idmunicipio' => 'idmunicipio']);
    }
}
