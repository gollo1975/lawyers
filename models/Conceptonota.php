<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "conceptonota".
 *
 * @property int $idconceptonota
 * @property string $concepto
 * @property int $estado
 *
 * @property Notacredito[] $notacreditos
 */
class Conceptonota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conceptonota';
    }

    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)){
            return false;
        }
        $this->concepto = strtoupper($this->concepto);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'integer'],
            [['concepto'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idconceptonota' => 'Id',
            'concepto' => 'Concepto',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotacreditos()
    {
        return $this->hasMany(Notacredito::className(), ['idconceptonota' => 'idconceptonota']);
    }
}
