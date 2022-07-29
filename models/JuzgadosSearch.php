<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Juzgados;

/**
 * JuzgadosSearch represents the model behind the search form of `app\models\Juzgados`.
 */
class JuzgadosSearch extends Juzgados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_juzgado', 'nombre_juzgado', 'direccion_juzgado', 'telefono_juzgado', 'celular_juzgado', 'email_juzgado', 'iddepartamento', 'idmunicipio', 'usuario', 'fecha_registro'], 'safe'],
            [['id_distrito', 'id_circuito', 'id_jurisdiccion', 'id_area_juzgado', 'estado_registro'], 'integer'],
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
        $query = Juzgados::find();

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
            'id_circuito' => $this->id_circuito,
            'id_jurisdiccion' => $this->id_jurisdiccion,
            'id_area_juzgado' => $this->id_area_juzgado,
            'fecha_registro' => $this->fecha_registro,
            'estado_registro' => $this->estado_registro,
        ]);

        $query->andFilterWhere(['like', 'codigo_juzgado', $this->codigo_juzgado])
            ->andFilterWhere(['like', 'nombre_juzgado', $this->nombre_juzgado])
            ->andFilterWhere(['like', 'direccion_juzgado', $this->direccion_juzgado])
            ->andFilterWhere(['like', 'telefono_juzgado', $this->telefono_juzgado])
            ->andFilterWhere(['like', 'celular_juzgado', $this->celular_juzgado])
            ->andFilterWhere(['like', 'email_juzgado', $this->email_juzgado])
            ->andFilterWhere(['like', 'iddepartamento', $this->iddepartamento])
            ->andFilterWhere(['like', 'idmunicipio', $this->idmunicipio])
            ->andFilterWhere(['like', 'usuario', $this->usuario]);

        return $dataProvider;
    }
}
