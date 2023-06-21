<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Abogados;

/**
 * AbogadosSearch represents the model behind the search form of `app\models\Abogados`.
 */
class AbogadosSearch extends Abogados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documento', 'nombres', 'apellidos', 'direccion_abogado', 'telefono_abogado', 'email_abogado', 'iddepartamento', 'idmunicipio', 'tarjeta_profesional', 'fecha_registro', 'usuario'], 'safe'],
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
        $query = Abogados::find();

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
            ->andFilterWhere(['like', 'direccion_abogado', $this->direccion_abogado])
            ->andFilterWhere(['like', 'telefono_abogado', $this->telefono_abogado])
            ->andFilterWhere(['like', 'email_abogado', $this->email_abogado])
            ->andFilterWhere(['like', 'iddepartamento', $this->iddepartamento])
            ->andFilterWhere(['like', 'idmunicipio', $this->idmunicipio])
            ->andFilterWhere(['like', 'tarjeta_profesional', $this->tarjeta_profesional])
            ->andFilterWhere(['like', 'usuario', $this->usuario]);

        return $dataProvider;
    }
}
