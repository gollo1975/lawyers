<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configuracion_formato_prefijo".
 *
 * @property int $id_configuracion_prefijo
 * @property string $formato
 * @property int $estado_formato
 *
 * @property FormatoContenido[] $formatoContenidos
 */
class ConfiguracionFormatoPrefijo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configuracion_formato_prefijo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['formato', 'estado_formato'], 'required'],
            [['estado_formato'], 'integer'],
            [['formato'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_configuracion_prefijo' => 'Id Configuracion Prefijo',
            'formato' => 'Formato',
            'estado_formato' => 'Estado Formato',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormatoContenidos()
    {
        return $this->hasMany(FormatoContenido::className(), ['id_configuracion_prefijo' => 'id_configuracion_prefijo']);
    }
    
}
