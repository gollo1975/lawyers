<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tiporecibocuenta".
 *
 * @property int $idtiporecibocuenta
 * @property int $cuenta
 * @property int $tipocuenta
 * @property int $idtiporecibo
 *
 * @property Tiporecibo $tiporecibo
 */
class Tiporecibocuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiporecibocuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuenta', 'tipocuenta', 'idtiporecibo'], 'required'],
            [['cuenta', 'tipocuenta', 'idtiporecibo'], 'integer'],
            [['idtiporecibo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoRecibo::className(), 'targetAttribute' => ['idtiporecibo' => 'idtiporecibo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idtiporecibocuenta' => 'Idtiporecibocuenta',
            'cuenta' => 'Cuenta',
            'tipocuenta' => 'Tipocuenta',
            'idtiporecibo' => 'Idtiporecibo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiporecibo()
    {
        return $this->hasOne(Tiporecibo::className(), ['idtiporecibo' => 'idtiporecibo']);
    }
}
