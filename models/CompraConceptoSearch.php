<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CompraConcepto;

/**
 * CompraConceptoSearch represents the model behind the search form of `app\models\CompraConcepto`.
 */
class CompraConceptoSearch extends CompraConcepto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_compra_concepto', 'cuenta', 'id_compra_tipo'], 'integer'],
            [['concepto'], 'safe'],
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
        $query = CompraConcepto::find();

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
            'id_compra_concepto' => $this->id_compra_concepto,
            'cuenta' => $this->cuenta,
            'id_compra_tipo' => $this->id_compra_tipo,
        ]);

        $query->andFilterWhere(['like', 'concepto', $this->concepto]);

        return $dataProvider;
    }
}
