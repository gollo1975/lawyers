<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Demandas;

/**
 * DemandasSearch represents the model behind the search form of `app\models\Demandas`.
 */
class DemandasSearch extends Demandas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nro_demanda', 'idcliente', 'id_clase_demanda', 'id_especialidad', 'numero_hojas'], 'integer'],
            [['codigo_juzgado', 'documento', 'documento_demandado', 'fecha_presentacion', 'fecha_registro', 'usuario', 'observacion'], 'safe'],
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
        $query = Demandas::find();

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
            'nro_demanda' => $this->nro_demanda,
            'idcliente' => $this->idcliente,
            'id_clase_demanda' => $this->id_clase_demanda,
            'id_especialidad' => $this->id_especialidad,
            'numero_hojas' => $this->numero_hojas,
            'fecha_presentacion' => $this->fecha_presentacion,
            'fecha_registro' => $this->fecha_registro,
        ]);

        $query->andFilterWhere(['like', 'codigo_juzgado', $this->codigo_juzgado])
            ->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['like', 'documento_demandado', $this->documento_demandado])
            ->andFilterWhere(['like', 'usuario', $this->usuario])
            ->andFilterWhere(['=', 'nro_demanda', $this->nro_demanda])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
