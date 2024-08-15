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
 * @property Matriculaempresa[] $matriculaempresas
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
    
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->departamento = strtoupper($this->departamento);
	
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iddepartamento', 'departamento'], 'required'],
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
            'iddepartamento' => 'Codigo',
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
    public function getMatriculaempresas()
    {
        return $this->hasMany(Matriculaempresa::className(), ['iddepartamento' => 'iddepartamento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasMany(Municipio::className(), ['iddepartamento' => 'iddepartamento']);
    }
    
    public function getEstadoRegistro() {
        if($this->activo == 0){
            $estadoregistro = 'NO';
        }else{
            $estadoregistro = 'SI';
        }
        return $estadoregistro;
    }
}
