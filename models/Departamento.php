<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "departamento".
 *
 * @property string $iddepartamento
 * @property string $departamento
 * @property int $activo
 *
 * @property Cliente[] $clientes
 * @property Municipio[] $municipios
 */
class Departamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iddepartamento', 'departamento'], 'required', 'message' => 'Campo requerido'],
            [['activo'], 'integer'],
            [['iddepartamento'], 'string', 'max' => 15],
            [['departamento'], 'string', 'max' => 100],
            [['iddepartamento'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddepartamento' => 'Id (Dane)',
            'departamento' => 'Departamento',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['iddepartamento' => 'iddepartamento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasMany(Municipio::className(), ['iddepartamento' => 'iddepartamento']);
    }
    
    public function getEstado()
    {
        if ($this->activo == 1){
            $activo = "SI";
        }else{
            $activo = "NO";
        }
        return $activo;
    }
}
