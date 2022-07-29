<?php

namespace app\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Resolucion;

/**
 * ResolucionSearch represents the model behind the search form of `app\models\Resolucion`.
 */
class ResolucionSearch extends Resolucion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idresolucion', 'activo','codigoactividad','descripcion'], 'integer'],
            [['codigoactividad', 'descripcion'], 'string'],
            [['nroresolucion', 'desde', 'hasta', 'fechacreacion','fechavencimiento', 'nitmatricula'], 'safe'],
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
        $query = Resolucion::find();

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
            'idresolucion' => $this->idresolucion,

        ]);

        $query->andFilterWhere(['like', 'nroresolucion', $this->nroresolucion])
            ->andFilterWhere(['like', 'desde', $this->desde])
            ->andFilterWhere(['like', 'hasta', $this->hasta])
            ->andFilterWhere(['like', 'nitmatricula', $this->nitmatricula])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'codigoactividad', $this->codigoactividad])
            ->andFilterWhere(['like', 'fechacreacion', $this->fechacreacion])
            ->andFilterWhere(['like', 'fechavencimiento', $this->fechavencimiento]);

        return $dataProvider;
    }
}
