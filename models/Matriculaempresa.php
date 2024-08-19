<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "matriculaempresa".
 *
 * @property string $nitmatricula
 * @property int $dv
 * @property string $razonsocialmatricula
 * @property string $nombrematricula
 * @property string $apellidomatricula
 * @property string $direccionmatricula
 * @property string $telefonomatricula
 * @property string $celularmatricula
 * @property string $emailmatricula
 * @property string $iddepartamento
 * @property string $idmunicipio
 * @property string $paginaweb
 * @property double $porcentajeiva
 * @property double $porcentajeretefuente
 * @property double $retefuente
 * @property double $porcentajereteiva
 * @property int $id_tipo_regimen
 * @property string $declaracion
 * @property int $id_banco_factura
 * @property int $idresolucion
 * @property string $nombresistema
 * @property int $gran_contribuyente
 * @property int $agente_retenedor
 * @property int $factura_venta_libre
 *
 * @property Banco $bancoFactura
 * @property TipoRegimen $tipoRegimen
 * @property Departamento $departamento
 * @property Municipio $municipio
 * @property Resolucion $resolucion
 */
class Matriculaempresa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'matriculaempresa';
    }
     public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->representante_legal = strtoupper($this->representante_legal);        
        $this->emailmatricula = strtolower($this->emailmatricula);   
        $this->razonsocialmatricula = strtoupper($this->razonsocialmatricula);   
        $this->nombrematricula = strtolower($this->nombrematricula);   
        $this->apellidomatricula = strtolower($this->apellidomatricula);   
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nitmatricula', 'dv', 'direccionmatricula', 'emailmatricula', 'iddepartamento', 'idmunicipio', 'id_tipo_regimen'], 'required'],
            [['dv', 'id_tipo_regimen'], 'integer'],
            [['porcentaje_iva'], 'number'],
            [['nombresistema', 'representante_legal'], 'string'],
            [['nitmatricula', 'telefonomatricula', 'celularmatricula', 'iddepartamento', 'idmunicipio'], 'string', 'max' => 15],
            [['razonsocialmatricula', 'nombrematricula', 'apellidomatricula', 'direccionmatricula', 'emailmatricula','nombre_completo'], 'string', 'max' => 40],
            [['representante_legal'], 'string', 'max' => 50],
            [['nitmatricula'], 'unique'],
            [['id_tipo_regimen'], 'exist', 'skipOnError' => true, 'targetClass' => TipoRegimen::className(), 'targetAttribute' => ['id_tipo_regimen' => 'id_tipo_regimen']],
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
            'nitmatricula' => 'Nit:',
            'dv' => 'Dv:',
            'razonsocialmatricula' => 'Razon Social:',
            'nombrematricula' => 'Nombres:',
            'apellidomatricula' => 'Apellidos:',
            'direccionmatricula' => 'Dirección:',
            'telefonomatricula' => 'Telefono:',
            'celularmatricula' => 'Celular:',
            'emailmatricula' => 'Email:',
            'iddepartamento' => 'Departamento:',
            'idmunicipio' => 'Municipio:',
            'porcentaje_iva' => 'Porcentaje Iva:',
            'id_tipo_regimen' => 'Tipo Regimen:',
            'nombresistema' => 'Nombre Sistema:',
            'representante_legal' => 'Representante legal:',
            'nombre_completo' => 'nombre_completo',
           
        ];
    }

   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoRegimen()
    {
        return $this->hasOne(TipoRegimen::className(), ['id_tipo_regimen' => 'id_tipo_regimen']);
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
