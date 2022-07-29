<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cuenta_pub".
 *
 * @property int $codigo_cuenta
 * @property string $nombre_cuenta
 * @property int $permite_movimientos
 * @property int $exige_nit
 * @property int $exige_centro_costo
 */
class CuentaPub extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuenta_pub';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_cuenta', 'nombre_cuenta'], 'required'],
            [['codigo_cuenta', 'permite_movimientos', 'exige_nit', 'exige_centro_costo'], 'integer'],
            [['nombre_cuenta'], 'string', 'max' => 150],
            [['codigo_cuenta'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo_cuenta' => 'Codigo Cuenta',
            'nombre_cuenta' => 'Nombre Cuenta',
            'permite_movimientos' => 'Permite Movimientos',
            'exige_nit' => 'Exige Nit',
            'exige_centro_costo' => 'Exige Centro Costo',
        ];
    }
    
    public function getPermitem()
    {
        if($this->permite_movimientos == 1){
            $permitem = "SI";
        }else{
            $permitem = "NO";
        }
        return $permitem;
    }
    
    public function getExigen()
    {
        if($this->exige_nit == 1){
            $exigen = "SI";
        }else{
            $exigen = "NO";
        }
        return $exigen;
    }
    
    public function getExigecc()
    {
        if($this->exige_centro_costo == 1){
            $exigecc = "SI";
        }else{
            $exigecc = "NO";
        }
        return $exigecc;
    }
    
    public function getCuentanombre()
    {
        return "{$this->codigo_cuenta} - {$this->nombre_cuenta}";
    }
}
