<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "demandas".
 *
 * @property int $nro_demanda
 * @property int $idcliente
 * @property string $codigo_juzgado
 * @property int $id_clase_demanda
 * @property int $id_especialidad
 * @property string $documento
 * @property string $documento_demandado
 * @property int $numero_hojas
 * @property string $fecha_presentacion
 * @property string $fecha_registro
 * @property string $usuario
 * @property string $observacion
 *
 * @property Cliente $cliente
 * @property Juzgados $codigoJuzgado
 * @property ClasesDemandas $claseDemanda
 * @property Especialidades $especialidad
 * @property Abogados $documento0
 * @property Demandados $documentoDemandado
 */
class Demandas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demandas';
    }
     public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	   
	$this->observacion = strtolower($this->observacion);
        $this->observacion = ucfirst($this->observacion);  
       		
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcliente', 'codigo_juzgado', 'id_clase_demanda', 'id_especialidad', 'documento', 'documento_demandado'], 'required'],
            [['idcliente', 'id_clase_demanda', 'id_especialidad', 'numero_hojas'], 'integer'],
            [['fecha_presentacion', 'fecha_registro'], 'safe'],
            [['observacion','radicado'], 'string'],
            [['codigo_juzgado', 'documento', 'documento_demandado'], 'string', 'max' => 15],
            [['usuario'], 'string', 'max' => 20],
            [['idcliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['idcliente' => 'idcliente']],
            [['codigo_juzgado'], 'exist', 'skipOnError' => true, 'targetClass' => Juzgados::className(), 'targetAttribute' => ['codigo_juzgado' => 'codigo_juzgado']],
            [['id_clase_demanda'], 'exist', 'skipOnError' => true, 'targetClass' => ClasesDemandas::className(), 'targetAttribute' => ['id_clase_demanda' => 'id_clase_demanda']],
            [['id_especialidad'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidades::className(), 'targetAttribute' => ['id_especialidad' => 'id_especialidad']],
            [['documento'], 'exist', 'skipOnError' => true, 'targetClass' => Abogados::className(), 'targetAttribute' => ['documento' => 'documento']],
            [['documento_demandado'], 'exist', 'skipOnError' => true, 'targetClass' => Demandados::className(), 'targetAttribute' => ['documento_demandado' => 'documento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nro_demanda' => 'Nro Demanda:',
            'idcliente' => 'Cliente:',
            'codigo_juzgado' => 'Juzgado:',
            'id_clase_demanda' => 'Tipo proceso:',
            'id_especialidad' => 'Especialidad:',
            'documento' => 'Abogado:',
            'documento_demandado' => 'Demandado:',
            'numero_hojas' => 'Numero folios:',
            'fecha_presentacion' => 'Fecha Presentación:',
            'fecha_registro' => 'Fecha Registro:',
            'usuario' => 'Usuario:',
            'observacion' => 'Observación:',
            'radicado' =>'Nro radicado:',
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
    public function getCodigoJuzgado()
    {
        return $this->hasOne(Juzgados::className(), ['codigo_juzgado' => 'codigo_juzgado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaseDemanda()
    {
        return $this->hasOne(ClasesDemandas::className(), ['id_clase_demanda' => 'id_clase_demanda']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspecialidad()
    {
        return $this->hasOne(Especialidades::className(), ['id_especialidad' => 'id_especialidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoAbogado()
    {
        return $this->hasOne(Abogados::className(), ['documento' => 'documento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoDemandado()
    {
        return $this->hasOne(Demandados::className(), ['documento' => 'documento_demandado']);
    }
}
