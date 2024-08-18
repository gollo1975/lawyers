<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cotizacion_detalle_talla".
 *
 * @property int $codigo_talla
 * @property int $id_talla
 * @property int $id
 * @property int $id_cotizacion
 * @property int $cantidad
 * @property string $fecha_registro
 * @property string $user_name
 *
 * @property Tallas $talla
 * @property CotizacionDetalle $id0
 * @property Cotizaciones $cotizacion
 */
class CotizacionDetalleTalla extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cotizacion_detalle_talla';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_talla', 'id', 'id_cotizacion', 'cantidad'], 'integer'],
            [['cantidad'], 'required'],
            [['fecha_registro'], 'safe'],
            [['user_name'], 'string', 'max' => 15],
            [['id_talla'], 'exist', 'skipOnError' => true, 'targetClass' => Tallas::className(), 'targetAttribute' => ['id_talla' => 'id_talla']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => CotizacionDetalle::className(), 'targetAttribute' => ['id' => 'id']],
            [['id_cotizacion'], 'exist', 'skipOnError' => true, 'targetClass' => Cotizaciones::className(), 'targetAttribute' => ['id_cotizacion' => 'id_cotizacion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo_talla' => 'Codigo Talla',
            'id_talla' => 'Id Talla',
            'id' => 'ID',
            'id_cotizacion' => 'Id Cotizacion',
            'cantidad' => 'Cantidad',
            'fecha_registro' => 'Fecha Registro',
            'user_name' => 'User Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalla()
    {
        return $this->hasOne(Tallas::className(), ['id_talla' => 'id_talla']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleCotizacion()
    {
        return $this->hasOne(CotizacionDetalle::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacion()
    {
        return $this->hasOne(Cotizaciones::className(), ['id_cotizacion' => 'id_cotizacion']);
    }
}
