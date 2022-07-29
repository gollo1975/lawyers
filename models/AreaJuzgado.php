<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area_juzgado".
 *
 * @property int $id_area_juzgado
 * @property string $area
 * @property int $estado_area
 */
class AreaJuzgado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'area_juzgado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area'], 'required'],
            [['estado_area'], 'integer'],
            [['area'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_area_juzgado' => 'Id Area Juzgado',
            'area' => 'Area',
            'estado_area' => 'Estado Area',
        ];
    }
}
