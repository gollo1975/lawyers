<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Juez;

/**
 * JuezSearch represents the model behind the search form of `app\models\Juez`.
 */
class JuezSearch extends Juez
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_juez', 'estado_juez'], 'integer'],
            [['nombre_juez'], 'safe'],
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
        $query = Juez::find();

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
            'id_juez' => $this->id_juez,
            'estado_juez' => $this->estado_juez,
        ]);

        $query->andFilterWhere(['like', 'nombre_juez', $this->nombre_juez]);

        return $dataProvider;
    }
}
