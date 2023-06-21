<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actuaciones".
 *
 * @property int $id_actuacion
 * @property int $id_tipo
 * @property int $nro_demanda
 * @property string $fecha_actuacion
 * @property string $fecha_inicio
 * @property string $fecha_finaliza
 * @property string $fecha_registro
 * @property string $usuario
 * @property string $anotacion
 *
 * @property TipoActuacion $tipo
 * @property Demandas $nroDemanda
 */
class Actuaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actuaciones';
    }
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	$this->anotacion = strtoupper($this->anotacion);
       		
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo', 'nro_demanda', 'anotacion'], 'required'],
            [['id_tipo', 'nro_demanda'], 'integer'],
            [['fecha_actuacion', 'fecha_inicio', 'fecha_finaliza', 'fecha_registro'], 'safe'],
            [['usuario'], 'string', 'max' => 20],
            [['anotacion'], 'string', 'max' => 200],
            [['id_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoActuacion::className(), 'targetAttribute' => ['id_tipo' => 'id_tipo']],
            [['nro_demanda'], 'exist', 'skipOnError' => true, 'targetClass' => Demandas::className(), 'targetAttribute' => ['nro_demanda' => 'nro_demanda']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_actuacion' => 'Id',
            'id_tipo' => 'Tipo actuación:',
            'fecha_actuacion' => 'Fecha Actuación',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_finaliza' => 'Fecha Finaliza',
            'fecha_registro' => 'Fecha Registro',
            'usuario' => 'Usuario',
            'anotacion' => 'Anotacion:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoActuacion::className(), ['id_tipo' => 'id_tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNroDemanda()
    {
        return $this->hasOne(Demandas::className(), ['nro_demanda' => 'nro_demanda']);
    }
}
