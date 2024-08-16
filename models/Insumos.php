<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "insumos".
 *
 * @property int $id_insumo
 * @property int $codigo_insumo
 * @property string $nombre_insumo
 * @property int $valor_costo
 * @property string $fecha_proceso
 * @property int $id_medida
 * @property int $id_clasificacion
 * @property string $user_name
 *
 * @property TipoMedida $medida
 * @property ClasificacionInsumo $clasificacion
 */
class Insumos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'insumos';
    }
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->nombre_insumo = strtoupper($this->nombre_insumo);
	
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_insumo', 'nombre_insumo', 'valor_costo', 'id_medida', 'id_clasificacion'], 'required'],
            [['codigo_insumo', 'valor_costo', 'id_medida', 'id_clasificacion'], 'integer'],
            [['fecha_proceso'], 'safe'],
            [['nombre_insumo'], 'string', 'max' => 40],
            [['user_name'], 'string', 'max' => 15],
            [['id_medida'], 'exist', 'skipOnError' => true, 'targetClass' => TipoMedida::className(), 'targetAttribute' => ['id_medida' => 'id_medida']],
            [['id_clasificacion'], 'exist', 'skipOnError' => true, 'targetClass' => ClasificacionInsumo::className(), 'targetAttribute' => ['id_clasificacion' => 'id_clasificacion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_insumo' => 'Id',
            'codigo_insumo' => 'Codigo insumo:',
            'nombre_insumo' => 'Nombre de insumo:',
            'valor_costo' => 'Costo unitario:',
            'fecha_proceso' => 'Fecha proceso:',
            'id_medida' => 'Tipo de medida:',
            'id_clasificacion' => 'Clasificacion:',
            'user_name' => 'User Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedida()
    {
        return $this->hasOne(TipoMedida::className(), ['id_medida' => 'id_medida']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasificacion()
    {
        return $this->hasOne(ClasificacionInsumo::className(), ['id_clasificacion' => 'id_clasificacion']);
    }
}
