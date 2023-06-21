<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra_tipo".
 *
 * @property int $id_compra_tipo
 * @property string $tipo
 * @property int $cuenta
 *
 * @property Compra[] $compras
 */
class CompraTipo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compra_tipo';
    }
    
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->tipo = strtoupper($this->tipo);	
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['porcentaje'], 'number'],
            //[['cuenta'], 'integer'],
            [['tipo'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_compra_tipo' => 'Id Compra Tipo',
            'tipo' => 'Tipo',
            //'porcentaje' => 'Porcentaje',
            //'cuenta' => 'Cuenta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compra::className(), ['id_compra_tipo' => 'id_compra_tipo']);
    }
}
