<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tallas;

/**
 * TallasSearch represents the model behind the search form of `app\models\Tallas`.
 */
class TallasSearch extends Tallas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_talla'], 'integer'],
            [['nombre_talla'], 'safe'],
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
        $query = Tallas::find();

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
            'id_talla' => $this->id_talla,
        ]);

        $query->andFilterWhere(['like', 'nombre_talla', $this->nombre_talla]);

        return $dataProvider;
    }
}
