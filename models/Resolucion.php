<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resolucion".
 *
 * @property int $idresolucion
 * @property string $nroresolucion
 * @property string $desde
 * @property string $hasta
 * @property string $fechacreacion
 * @property string $fechavencimiento
 * @property string $nitmatricula
 * @property int $codigoactividad
 * @property string $descripcion
 * @property int $activo
 *
 * @property Facturaventa[] $facturaventas
 */
class Resolucion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resolucion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nroresolucion', 'desde', 'hasta', 'fechacreacion', 'fechavencimiento', 'codigoactividad', 'descripcion'], 'required'],
            [['fechacreacion', 'fechavencimiento'], 'safe'],
            [['codigoactividad', 'activo'], 'integer'],
            [['nroresolucion'], 'string', 'max' => 40],
            [['desde', 'hasta'], 'string', 'max' => 10],
            [['nitmatricula'], 'string', 'max' => 11],
            [['descripcion'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idresolucion' => 'Id',
            'nroresolucion' => 'N° Resolucion',
            'desde' => 'Desde',
            'hasta' => 'Hasta',
            'fechacreacion' => 'Fecha Resolución',
            'fechavencimiento' => 'Fecha Vencimiento',
            'nitmatricula' => 'Nitmatricula',
            'codigoactividad' => 'Código Actividad',
            'descripcion' => 'Descripción',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaventas()
    {
        return $this->hasMany(Facturaventa::className(), ['idresolucion' => 'idresolucion']);
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
