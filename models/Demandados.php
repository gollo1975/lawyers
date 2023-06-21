<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "demandados".
 *
 * @property string $documento
 * @property int $id_tipo_documento
 * @property string $nombres
 * @property string $apellidos
 * @property string $nombre_completo
 * @property string $direccion_demandado
 * @property string $telefono_demandado
 * @property string $email_demandado
 * @property string $iddepartamento
 * @property string $idmunicipio
 * @property string $fecha_registro
 * @property string $usuario
 * @property string $observacion
 *
 * @property Tipodocumento $tipoDocumento
 */
class Demandados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demandados';
    }
     public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
     
        $this->observacion = strtoupper($this->observacion); 
        $this->nombres = strtoupper($this->nombres);  
        $this->apellidos = strtoupper($this->apellidos);  
        $this->direccion_demandado = strtoupper($this->direccion_demandado);  
        $this->email_demandado = strtolower($this->email_demandado);  
 
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documento', 'id_tipo_documento', 'nombres', 'direccion_demandado', 'telefono_demandado', 'iddepartamento', 'idmunicipio'], 'required'],
            [['id_tipo_documento'], 'integer'],
            [['fecha_registro'], 'safe'],
            [['documento', 'telefono_demandado', 'iddepartamento', 'idmunicipio'], 'string', 'max' => 15],
            [['nombres', 'apellidos'], 'string', 'max' => 30],
            [['nombre_completo'], 'string', 'max' => 60],
            [['direccion_demandado', 'email_demandado'], 'string', 'max' => 50],
            [['observacion'], 'string', 'max' => 200],
            [['usuario'], 'string', 'max' => 20],
            [['documento'], 'unique'],
            [['id_tipo_documento'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDocumento::className(), 'targetAttribute' => ['id_tipo_documento' => 'id_tipo_documento']],
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
            'documento' => 'Documento',
            'id_tipo_documento' => 'Tipo documento:',
            'nombres' => 'Nombres:',
            'apellidos' => 'Apellidos:',
            'nombre_completo' => 'Nombre completo:',
            'direccion_demandado' => 'Direccion:',
            'telefono_demandado' => 'Telefóno:',
            'email_demandado' => 'Email:',
            'iddepartamento' => 'Departamento:',
            'idmunicipio' => 'Municipio:',
            'fecha_registro' => 'Fecha registro:',
            'usuario' => 'Usuario',
            'observacion' => 'Observacion:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoDocumento()
    {
        return $this->hasOne(TipoDocumento::className(), ['id_tipo_documento' => 'id_tipo_documento']);
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
