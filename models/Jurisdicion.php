<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jurisdicion".
 *
 * @property int $id_jurisdicion
 * @property string $jurisdicion
 * @property int $estado_jurisdicion
 */
class Jurisdicion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jurisdicion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jurisdiccion','estado_jurisdiccion'], 'required'],
            [['estado_jurisdiccion'], 'integer'],
            [['jurisdiccion'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jurisdiccion' => 'Código',
            'jurisdiccion' => 'Jurisdiccion',
            'estado_jurisdiccion' => 'Activ',
        ];
    }
}
