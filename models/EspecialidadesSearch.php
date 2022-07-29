<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Especialidades;

/**
 * EspecialidadesSearch represents the model behind the search form of `app\models\Especialidades`.
 */
class EspecialidadesSearch extends Especialidades
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_especialidad'], 'integer'],
            [['especialidad', 'fecha_proceso', 'usuario'], 'safe'],
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
        $query = Especialidades::find();

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
            'id_especialidad' => $this->id_especialidad,
            'especialidad' => $this->especialidad,
        ]);

        $query->andFilterWhere(['like', 'especialidad', $this->especialidad]);

        return $dataProvider;
    }
}
