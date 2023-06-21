<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "juzgados".
 *
 * @property string $codigo_juzgado
 * @property string $nombre_juzgado
 * @property string $direccion_juzgado
 * @property string $telefono_juzgado
 * @property string $celular_juzgado
 * @property string $email_juzgado
 * @property string $iddepartamento
 * @property string $idmunicipio
 * @property int $id_distrito
 * @property int $id_circuito
 * @property int $id_jurisdiccion
 * @property int $id_area_juzgado
 * @property string $usuario
 * @property string $fecha_registro
 * @property int $estado_registro
 *
 * @property Distrito $distrito
 * @property Circuito $circuito
 * @property Jurisdicion $jurisdiccion
 * @property AreaJuzgado $areaJuzgado
 */
class Juzgados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'juzgados';
    }
    
     public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->nombre_juzgado = strtoupper($this->nombre_juzgado);
	$this->direccion_juzgado = strtoupper($this->direccion_juzgado);
        $this->email_juzgado = strtolower($this->email_juzgado);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_juzgado', 'nombre_juzgado', 'iddepartamento', 'idmunicipio', 'id_distrito', 'id_circuito', 'id_jurisdiccion', 'id_area_juzgado'], 'required'],
            [['id_distrito', 'id_circuito', 'id_jurisdiccion', 'id_area_juzgado', 'estado_registro'], 'integer'],
            [['fecha_registro'], 'safe'],
            [['codigo_juzgado', 'celular_juzgado', 'iddepartamento', 'idmunicipio'], 'string', 'max' => 15],
            [['nombre_juzgado', 'direccion_juzgado'], 'string', 'max' => 70],
            [['telefono_juzgado'], 'string', 'max' => 10],
            [['email_juzgado'], 'string', 'max' => 50],
            [['usuario'], 'string', 'max' => 20],
            [['codigo_juzgado'], 'unique'],
            [['id_distrito'], 'exist', 'skipOnError' => true, 'targetClass' => Distrito::className(), 'targetAttribute' => ['id_distrito' => 'id_distrito']],
            [['id_circuito'], 'exist', 'skipOnError' => true, 'targetClass' => Circuito::className(), 'targetAttribute' => ['id_circuito' => 'id_circuito']],
            [['id_jurisdiccion'], 'exist', 'skipOnError' => true, 'targetClass' => Jurisdicion::className(), 'targetAttribute' => ['id_jurisdiccion' => 'id_jurisdiccion']],
            [['id_area_juzgado'], 'exist', 'skipOnError' => true, 'targetClass' => AreaJuzgado::className(), 'targetAttribute' => ['id_area_juzgado' => 'id_area_juzgado']],
            [['iddepartamento'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['iddepartamento' => 'iddepartamento']],
            [['idmunicipio'], 'exist', 'skipOnError' => true, 'targetClass' => Municipio::className(), 'targetAttribute' => ['idmunicipio' => 'idmunicipio']],
            [['id_juez'], 'exist', 'skipOnError' => true, 'targetClass' => Juez::className(), 'targetAttribute' => ['id_juez' => 'id_juez']],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo_juzgado' => 'Codigo:',
            'nombre_juzgado' => 'Juzgado:',
            'direccion_juzgado' => 'Dirección:',
            'telefono_juzgado' => 'Teléfono:',
            'celular_juzgado' => 'Celular:',
            'email_juzgado' => 'Email',
            'iddepartamento' => 'Departamento:',
            'idmunicipio' => 'Municipio',
            'id_distrito' => 'Distrito:',
            'id_circuito' => 'Circuito:',
            'id_jurisdiccion' => 'Jurisdicción:',
            'id_area_juzgado' => 'Area:',
            'id_juez' => 'Juez:',
            'usuario' => 'Usuario',
            'fecha_registro' => 'Fecha Registro',
            'estado_registro' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrito()
    {
        return $this->hasOne(Distrito::className(), ['id_distrito' => 'id_distrito']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCircuito()
    {
        return $this->hasOne(Circuito::className(), ['id_circuito' => 'id_circuito']);
    }
    
     public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['iddepartamento' => 'iddepartamento']);
    }
    
     public function getMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['idmunicipio' => 'idmunicipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurisdiccion()
    {
        return $this->hasOne(Jurisdicion::className(), ['id_jurisdiccion' => 'id_jurisdiccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaJuzgado()
    {
        return $this->hasOne(AreaJuzgado::className(), ['id_area_juzgado' => 'id_area_juzgado']);
    }
    
     public function getJuez()
    {
        return $this->hasOne(Juez::className(), ['id_juez' => 'id_juez']);
    }
    
    public function getActivo() {
        if($this->estado_registro == 0){
            $estado = 'SI';
        }else{
            $estado = 'NO';
        }
        return $estado;
    }
}
