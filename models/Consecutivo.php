<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consecutivo".
 *
 * @property int $consecutivo_pk
 * @property string $nombre
 * @property int $consecutivo
 */
class Consecutivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consecutivo';
    }

    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)){
            return false;
        }
        $this->nombre = strtoupper($this->nombre);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'consecutivo'], 'required'],
            [['consecutivo'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'consecutivo_pk' => 'Consecutivo Pk',
            'nombre' => 'Nombre',
            'consecutivo' => 'Consecutivo',
        ];
    }
}
