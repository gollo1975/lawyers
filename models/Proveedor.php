<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proveedor".
 *
 * @property int $idproveedor
 * @property int $id_tipo_documento
 * @property int $cedulanit
 * @property int $dv
 * @property string $razonsocial
 * @property string $nombreproveedor
 * @property string $apellidoproveedor
 * @property string $nombrecorto
 * @property string $direccionproveedor
 * @property string $telefonoproveedor
 * @property string $celularproveedor
 * @property string $emailproveedor
 * @property string $contacto
 * @property string $telefonocontacto
 * @property string $celularcontacto
 * @property string $formapago
 * @property int $plazopago
 * @property string $iddepartamento
 * @property string $idmunicipio
 * @property string $nitmatricula
 * @property string $tiporegimen
 * @property int $autoretenedor
 * @property int $retencioniva
 * @property int $retencionfuente
 * @property string $observacion
 * @property string $fechaingreso
 *
 * @property Tipodocumento $tipo
 * @property Departamento $departamento
 * @property Municipio $municipio
 */
class Proveedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proveedor';
    }

    public function beforeSave($insert) {
	if(!parent::beforeSave($insert)){
            return false;
        }
	# ToDo: Cambiar a cliente cargada de configuración.    
	$this->nombreproveedor = strtoupper($this->nombreproveedor);
	$this->apellidoproveedor = strtoupper($this->apellidoproveedor);
	$this->razonsocial = strtoupper($this->razonsocial);
	$this->nombrecorto = strtoupper($this->nombrecorto);
	$this->direccionproveedor = strtoupper($this->direccionproveedor);
	$this->contacto = strtoupper($this->contacto);
	$this->observacion = strtoupper($this->observacion);
        $this->banco = strtoupper($this->banco);
        return true;
    }

    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoDocumento::className(), ['id_tipo_documento' => 'id_tipo_documento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['iddepartamento' => 'iddepartamento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['idmunicipio' => 'idmunicipio']);
    }
    
    public function getNombreProveedores()
    {
        return "{$this->nombrecorto} - {$this->cedulanit}";
    }
    
    public function getAutoretener()
    {
        if($this->autoretenedor == 1){
            $autoretenedor = "SI";
        }else{
            $autoretenedor = "NO";
        }
        return $autoretenedor;
    }
    
    public function getNaturalezas()
    {
        if($this->naturaleza == 1){
            $naturaleza = "PUBLICA";
        }
        if($this->naturaleza == 2){
            $naturaleza = "PRIVADA";
        }
        if($this->naturaleza == 3){
            $naturaleza = "COOPERATIVA";
        }
        return $naturaleza;
    }
    
    public function getSociedades()
    {
        if($this->sociedad == 1){
            $sociedad = "NATURAL";
        }
        if($this->sociedad == 2){
            $sociedad = "JURIDICA";
        }        
        return $sociedad;
    }
    
    public function getRegimen()
    {
        if($this->tiporegimen == 1){
            $tiporegimen = "CÓMUN";
        }
        if($this->tiporegimen == 2){
            $tiporegimen = "SIMPLIFICADO";
        }        
        return $tiporegimen;
    }
    
    public function getTcuenta()
    {
        if($this->tipocuenta == 0){
            $tipo = "CUENTA DE AHORROS";
        }else{
            $tipo = "CUENTA CORRIENTE";
        }
        return $tipo;
    }
    public function getGeneramoda()
    {
        if($this->genera_moda == 0){
            $generamoda = "NO";
        }else{
            $generamoda = "SI";
        }
        return $generamoda;
    }
}