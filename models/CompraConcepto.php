<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra_concepto".
 *
 * @property int $id_compra_concepto
 * @property string $concepto
 * @property int $cuenta
 * @property int $id_compra_tipo
 *
 * @property Compra[] $compras
 * @property CompraTipo $compraTipo
 */
class CompraConcepto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compra_concepto';
    }
    
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->concepto = strtoupper($this->concepto);		
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['concepto', 'cuenta', 'id_compra_tipo','base_retencion','porcentaje_iva','porcentaje_retefuente','porcentaje_reteiva','base_aiu'], 'required'],
            [['cuenta', 'id_compra_tipo'], 'integer'],
            [['base_retencion', 'porcentaje_iva','porcentaje_retefuente','porcentaje_reteiva','base_aiu'], 'number'],
            [['concepto'], 'string', 'max' => 100],
            [['id_compra_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => CompraTipo::className(), 'targetAttribute' => ['id_compra_tipo' => 'id_compra_tipo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_compra_concepto' => 'Id',
            'concepto' => 'Concepto',
            'cuenta' => 'Cuenta',
            'id_compra_tipo' => 'Compra Tipo',
            'base_retencion' => 'Base Retencion',
            'porcentaje_retefuente' => '% Retefuente',
            'porcentaje_iva' => '% Iva',
            'porcentaje_reteiva' => ' % Reteiva',
            'base_aiu' => 'Base AIU',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compra::className(), ['id_compra_concepto' => 'id_compra_concepto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompraTipo()
    {
        return $this->hasOne(CompraTipo::className(), ['id_compra_tipo' => 'id_compra_tipo']);
    }
}
