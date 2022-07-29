<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "abogados".
 *
 * @property string $documento
 * @property int $id_tipo_documento
 * @property string $nombres
 * @property string $apellidos
 * @property string $direccion_abogado
 * @property string $telefono_abogado
 * @property string $email_abogado
 * @property string $iddepartamento
 * @property string $idmunicipio
 * @property string $tarjeta_profesional
 * @property string $fecha_registro
 * @property string $usuario
 *
 * @property Tipodocumento $tipoDocumento
 */
class Abogados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abogados';
    }
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
     
        $this->observacion = strtoupper($this->observacion); 
        $this->nombres = strtoupper($this->nombres);  
        $this->apellidos = strtoupper($this->apellidos);  
        $this->direccion_abogado = strtoupper($this->direccion_abogado);  
        $this->email_abogado = strtolower($this->email_abogado);  
 
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documento', 'id_tipo_documento', 'nombres', 'direccion_abogado', 'telefono_abogado', 'iddepartamento', 'idmunicipio', 'tarjeta_profesional','fecha_nacimiento'], 'required'],
            [['id_tipo_documento'], 'integer'],
            [['fecha_registro','fecha_nacimiento'], 'safe'],
            [['documento', 'telefono_abogado', 'iddepartamento', 'idmunicipio'], 'string', 'max' => 15],
            [['nombres', 'apellidos'], 'string', 'max' => 30],
            [['direccion_abogado', 'email_abogado'], 'string', 'max' => 50],
            [['observacion'], 'string', 'max' => 200],
            [['tarjeta_profesional'], 'string', 'max' => 10],
            [['usuario'], 'string', 'max' => 20],
            [['documento'], 'unique'],
            [['id_tipo_documento'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodocumento::className(), 'targetAttribute' => ['id_tipo_documento' => 'id_tipo_documento']],
            [['iddepartamento'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['iddepartamento' => 'iddepartamento']],
            [['idmunicipio'], 'exist', 'skipOnError' => true, 'targetClass' => Municipio::className(), 'targetAttribute' => ['idmunicipio' => 'idmunicipio']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'documento' => 'Documento:',
            'id_tipo_documento' => 'Tipo documento:',
            'nombre_completo' => 'Abogado:',
            'direccion_abogado' => 'Direccion:',
            'telefono_abogado' => 'Telefono:',
            'email_abogado' => 'Email:',
            'iddepartamento' => 'Departamento:',
            'idmunicipio' => 'Municipio:',
            'tarjeta_profesional' => 'Tarjeta profesional:',
            'fecha_registro' => 'Fecha Registro:',
            'usuario' => 'Usuario:',
            'observacion' => 'Observacion:',
            'fecha_nacimiento' => 'Fecha nacimiento:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoDocumento()
    {
        return $this->hasOne(Tipodocumento::className(), ['id_tipo_documento' => 'id_tipo_documento']);
    }
    
     public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['iddepartamento' => 'iddepartamento']);
    }
     public function getMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['idmunicipio' => 'idmunicipio']);
    }
}
