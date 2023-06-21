<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Compra;

/**
 * CompraSearch represents the model behind the search form of `app\models\Compra`.
 */
class CompraSearch extends Compra
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_compra', 'id_compra_concepto', 'id_proveedor', 'estado', 'autorizado','numero','factura'], 'integer'],
            [['porcentajeiva', 'porcentajefuente', 'porcentajereteiva', 'subtotal', 'retencionfuente', 'impuestoiva', 'retencioniva', 'saldo', 'total'], 'number'],
            [['usuariosistema', 'observacion', 'fechacreacion', 'fechainicio', 'fechavencimiento'], 'safe'],
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
        $query = Compra::find();

        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_compra' => SORT_DESC]] // Agregar esta linea para agregar el orden por defecto
        ]);        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_compra' => $this->id_compra,
            'id_compra_concepto' => $this->id_compra_concepto,
            'porcentajeiva' => $this->porcentajeiva,
            'porcentajefuente' => $this->porcentajefuente,
            'porcentajereteiva' => $this->porcentajereteiva,
            'subtotal' => $this->subtotal,
            'retencionfuente' => $this->retencionfuente,
            'impuestoiva' => $this->impuestoiva,
            'retencioniva' => $this->retencioniva,
            'saldo' => $this->saldo,
            'total' => $this->total,
            'id_proveedor' => $this->id_proveedor,
            'estado' => $this->estado,
            'autorizado' => $this->autorizado,
            'fechacreacion' => $this->fechacreacion,
            'fechainicio' => $this->fechainicio,
            'fechavencimiento' => $this->fechavencimiento,
            'numero' => $this->numero,
            'factura' => $this->factura,
        ]);

        $query->andFilterWhere(['like', 'usuariosistema', $this->usuariosistema])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
