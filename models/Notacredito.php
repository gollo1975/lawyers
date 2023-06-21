<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notacredito".
 *
 * @property int $idnotacredito
 * @property int $idcliente
 * @property string $fecha
 * @property string $fechapago
 * @property int $idconceptonota
 * @property double $valor
 * @property double $iva
 * @property double $reteiva
 * @property double $retefuente
 * @property double $total
 * @property int $numero
 * @property int $autorizado
 * @property int $anulado
 * @property string $usuariosistema
 * @property string $observacion
 *
 * @property Cliente $cliente
 * @property Conceptonota $conceptonota
 */
class Notacredito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notacredito';
    }
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->observacion = strtoupper($this->observacion);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcliente', 'idconceptonota'], 'required'],
            [['idcliente', 'idconceptonota', 'numero', 'autorizado', 'anulado'], 'integer'],
            [['fecha', 'fechapago'], 'safe'],
            [['valor','iva','reteiva','retefuente','total'], 'number'],
            [['observacion'], 'string'],
            [['usuariosistema'], 'string', 'max' => 50],
            [['idcliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['idcliente' => 'idcliente']],
            [['idconceptonota'], 'exist', 'skipOnError' => true, 'targetClass' => Conceptonota::className(), 'targetAttribute' => ['idconceptonota' => 'idconceptonota']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idnotacredito' => 'Id',
            'idcliente' => 'Cliente',
            'fecha' => 'Fecha',
            'fechapago' => 'Fechapago',
            'idconceptonota' => 'Concepto',
            'valor' => 'Valor',
            'iva' => 'Iva',
            'reteiva' => 'Rete Iva',
            'retefuente' => 'Rete Fuente',
            'total' => 'Total',
            'numero' => 'Numero',
            'autorizado' => 'Autorizado',
            'anulado' => 'Anulado',
            'usuariosistema' => 'Usuariosistema',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['idcliente' => 'idcliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConceptonota()
    {
        return $this->hasOne(Conceptonota::className(), ['idconceptonota' => 'idconceptonota']);
    }
    
    public function getAutorizar()
    {
        if($this->autorizado == 1){
            $autorizar = "SI";
        }else{
            $autorizar = "NO";
        }
        return $autorizar;
    }
}
