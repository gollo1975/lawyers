<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Facturaventa;

/**
 * FacturaventaSearch represents the model behind the search form of `app\models\Facturaventa`.
 */
class FacturaventaSearch extends Facturaventa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idfactura', 'nro_factura', 'plazopago', 'idcliente', 'nro_demanda', 'idresolucion', 'estado', 'autorizado', 'tipo_factura'], 'integer'],
            [['fecha_inicio', 'fecha_vencimiento', 'fechacreacion', 'formapago', 'valorletras', 'usuariosistema', 'observacion', 'nrofacturaelectronica'], 'safe'],
            [['porcentajeiva', 'porcentajefuente', 'porcentajereteiva', 'subtotal', 'retencionfuente', 'impuestoiva', 'retencioniva', 'saldo', 'totalpagar'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Facturaventa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idfactura' => $this->idfactura,
            'nro_factura' => $this->nro_factura,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'fechacreacion' => $this->fechacreacion,
            'plazopago' => $this->plazopago,
            'porcentajeiva' => $this->porcentajeiva,
            'porcentajefuente' => $this->porcentajefuente,
            'porcentajereteiva' => $this->porcentajereteiva,
            'subtotal' => $this->subtotal,
            'retencionfuente' => $this->retencionfuente,
            'impuestoiva' => $this->impuestoiva,
            'retencioniva' => $this->retencioniva,
            'saldo' => $this->saldo,
            'totalpagar' => $this->totalpagar,
            'idcliente' => $this->idcliente,
            'nro_demanda' => $this->nro_demanda,
            'idresolucion' => $this->idresolucion,
            'estado' => $this->estado,
            'autorizado' => $this->autorizado,
            'tipo_factura' => $this->tipo_factura,
        ]);

        $query->andFilterWhere(['like', 'formapago', $this->formapago])
            ->andFilterWhere(['like', 'valorletras', $this->valorletras])
            ->andFilterWhere(['like', 'usuariosistema', $this->usuariosistema])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'nrofacturaelectronica', $this->nrofacturaelectronica]);

        return $dataProvider;
    }
}
