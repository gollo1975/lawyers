<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Demandados;

/**
 * DemandadosSearch represents the model behind the search form of `app\models\Demandados`.
 */
class DemandadosSearch extends Demandados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documento', 'nombres', 'apellidos', 'nombre_completo', 'direccion_demandado', 'telefono_demandado', 'email_demandado', 'iddepartamento', 'idmunicipio', 'fecha_registro', 'usuario', 'observacion'], 'safe'],
            [['id_tipo_documento'], 'integer'],
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
        $query = Demandados::find();

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
            'id_tipo_documento' => $this->id_tipo_documento,
            'fecha_registro' => $this->fecha_registro,
        ]);

        $query->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'nombre_completo', $this->nombre_completo])
            ->andFilterWhere(['like', 'direccion_demandado', $this->direccion_demandado])
            ->andFilterWhere(['like', 'telefono_demandado', $this->telefono_demandado])
            ->andFilterWhere(['like', 'email_demandado', $this->email_demandado])
            ->andFilterWhere(['like', 'iddepartamento', $this->iddepartamento])
            ->andFilterWhere(['like', 'idmunicipio', $this->idmunicipio])
            ->andFilterWhere(['like', 'usuario', $this->usuario])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
