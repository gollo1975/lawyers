<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Distrito;

/**
 * DistritoSearch represents the model behind the search form of `app\models\Distrito`.
 */
class DistritoSearch extends Distrito
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_distrito', 'estado'], 'integer'],
            [['nombre_distrito'], 'safe'],
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
        $query = Distrito::find();

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
            'id_distrito' => $this->id_distrito,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'nombre_distrito', $this->nombre_distrito]);
        $query->andFilterWhere(['like', 'estado', $this->estado]);
         $query->andFilterWhere(['=', 'id_distrito', $this->id_distrito]); 

        return $dataProvider;
    }
}
