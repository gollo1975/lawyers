<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipio".
 *
 * @property string $idmunicipio
 * @property string $codigomunicipio
 * @property string $municipio
 * @property string $iddepartamento
 * @property int $activo
 *
 * @property Cliente[] $clientes
 * @property Matriculaempresa[] $matriculaempresas
 * @property Departamento $departamento
 */
class Municipio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'municipio';
    }
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->municipio = strtoupper($this->municipio);
	
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idmunicipio', 'codigomunicipio', 'municipio'], 'required'],
            [['activo'], 'integer'],
            [['idmunicipio', 'codigomunicipio', 'iddepartamento'], 'string', 'max' => 15],
            [['municipio'], 'string', 'max' => 100],
            [['idmunicipio'], 'unique'],
            [['iddepartamento'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['iddepartamento' => 'iddepartamento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idmunicipio' => 'Codigo',
            'codigomunicipio' => 'Dane',
            'municipio' => 'Municipio',
            'iddepartamento' => 'Departamento',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['idmunicipio' => 'idmunicipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculaempresas()
    {
        return $this->hasMany(Matriculaempresa::className(), ['idmunicipio' => 'idmunicipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['iddepartamento' => 'iddepartamento']);
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
