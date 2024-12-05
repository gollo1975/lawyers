<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "referencia_producto".
 *
 * @property int $codigo
 * @property string $descripcion_referencia
 * @property int $id_grupo
 * @property int $costo_producto
 * @property string $fecha_registro
 * @property string $user_name
 * @property string $descripcion
 *
 * @property GrupoReferencia $grupo
 */
class ReferenciaProducto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referencia_producto';
    }
    
    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->descripcion_referencia = strtoupper($this->descripcion_referencia);
        $this->codigo_homologado = strtoupper($this->codigo_homologado);
	
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion_referencia', 'id_grupo'], 'required'],
            [['codigo', 'id_grupo', 'costo_producto','generar_codigo','estado_registro'], 'integer'],
            [['fecha_registro'], 'safe'],
            [['descripcion'], 'string'],
            [['descripcion_referencia'], 'string', 'max' => 40],
            [['user_name','codigo_homologado'], 'string', 'max' => 15],
            [['codigo'], 'unique'],
            [['nota_comercial'],'string', 'max' => 230],
            [['nota_interna'],'string', 'max' => 100],
            [['id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => GrupoReferencia::className(), 'targetAttribute' => ['id_grupo' => 'id_grupo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo:',
            'descripcion_referencia' => 'Referencia:',
            'id_grupo' => 'Grupo:',
            'costo_producto' => 'Costo producto:',
            'fecha_registro' => 'Fecha registro:',
            'user_name' => 'User name',
            'descripcion' => 'Ficha tecnica',
            'codigo_homologado' => 'Codigo homologado:',
            'nota_comercial' => 'Nota comercial:',
            'nota_interna' => 'Nota interna:',
            'generar_codigo' => 'Generar codigo:',
            'estado_registro' => 'Registro activo:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(GrupoReferencia::className(), ['id_grupo' => 'id_grupo']);
    }
    
    //estado
    public function getEstadoRegistro() {
        if($this->estado_registro == 0){
            $estadoregistro = 'NO';
        }else{
            $estadoregistro = 'SI';
        }
        return $estadoregistro;
    }
}
