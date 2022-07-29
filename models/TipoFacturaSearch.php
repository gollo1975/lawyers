<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoFactura;

/**
 * TipoFacturaSearch represents the model behind the search form of `app\models\TipoFactura`.
 */
class TipoFacturaSearch extends TipoFactura
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_factura', 'estado'], 'integer'],
            [['concepto'], 'safe'],
            [['porcentaje_retencion'], 'number'],
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
        $query = TipoFactura::find();

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
            'tipo_factura' => $this->tipo_factura,
            'porcentaje_retencion' => $this->porcentaje_retencion,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'concepto', $this->concepto]);

        return $dataProvider;
    }
}
