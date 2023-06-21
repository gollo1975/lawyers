<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CuentaPub;

/**
 * CuentaPubSearch represents the model behind the search form of `app\models\CuentaPub`.
 */
class CuentaPubSearch extends CuentaPub
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_cuenta', 'permite_movimientos', 'exige_nit', 'exige_centro_costo'], 'integer'],
            [['nombre_cuenta'], 'safe'],
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
        $query = CuentaPub::find();

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
            'codigo_cuenta' => $this->codigo_cuenta,
            'permite_movimientos' => $this->permite_movimientos,
            'exige_nit' => $this->exige_nit,
            'exige_centro_costo' => $this->exige_centro_costo,
        ]);

        $query->andFilterWhere(['like', 'nombre_cuenta', $this->nombre_cuenta]);

        return $dataProvider;
    }
}
