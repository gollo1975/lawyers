<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_medida".
 *
 * @property int $id_medida
 * @property string $medida
 *
 * @property Insumos[] $insumos
 */
class TipoMedida extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_medida';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['medida'], 'required'],
            [['medida'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_medida' => 'Id Medida',
            'medida' => 'Medida',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsumos()
    {
        return $this->hasMany(Insumos::className(), ['id_medida' => 'id_medida']);
    }
}
