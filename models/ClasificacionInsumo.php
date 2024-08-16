<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clasificacion_insumo".
 *
 * @property int $id_clasificacion
 * @property string $concepto
 *
 * @property Insumos[] $insumos
 */
class ClasificacionInsumo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasificacion_insumo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['concepto'], 'required'],
            [['concepto'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_clasificacion' => 'Id Clasificacion',
            'concepto' => 'Concepto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsumos()
    {
        return $this->hasMany(Insumos::className(), ['id_clasificacion' => 'id_clasificacion']);
    }
}
