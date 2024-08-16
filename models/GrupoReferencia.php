<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo_referencia".
 *
 * @property int $id_grupo
 * @property string $concepto
 *
 * @property ReferenciaProducto[] $referenciaProductos
 */
class GrupoReferencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupo_referencia';
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
            'id_grupo' => 'Id Grupo',
            'concepto' => 'Concepto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenciaProductos()
    {
        return $this->hasMany(ReferenciaProducto::className(), ['id_grupo' => 'id_grupo']);
    }
}
