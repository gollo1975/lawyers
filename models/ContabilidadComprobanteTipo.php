<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contabilidad_comprobante_tipo".
 *
 * @property int $id_contabilidad_comprobante_tipo
 * @property string $tipo
 * @property string $codigo
 * @property int $estado
 */
class ContabilidadComprobanteTipo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contabilidad_comprobante_tipo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'integer'],
            [['tipo'], 'string', 'max' => 30],
            [['codigo'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_contabilidad_comprobante_tipo' => 'Id',
            'tipo' => 'Tipo',
            'codigo' => 'Codigo',
            'estado' => 'Activo',
        ];
    }
    
    public function getActivo()
    {
        if($this->estado == 1){
            $estado = "NO";
        }else{
            $estado = "SI";
        }
        return $estado;
    }
}
