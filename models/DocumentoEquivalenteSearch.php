<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocumentoEquivalente;

/**
 * DocumentoEquivalenteSearch represents the model behind the search form of `app\models\DocumentoEquivalente`.
 */
class DocumentoEquivalenteSearch extends DocumentoEquivalente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['consecutivo', 'identificacion'], 'integer'],
            [['nombre_completo', 'fecha', 'idmunicipio', 'descripcion'], 'safe'],
            [['valor', 'subtotal', 'retencion_fuente', 'porcentaje'], 'number'],
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
        $query = DocumentoEquivalente::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['fecha' => SORT_DESC]] // Agregar esta linea para agregar el orden por defecto
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'consecutivo' => $this->consecutivo,
            'identificacion' => $this->identificacion,
            'fecha' => $this->fecha,
            'valor' => $this->valor,
            'subtotal' => $this->subtotal,
            'retencion_fuente' => $this->retencion_fuente,
            'porcentaje' => $this->porcentaje,
        ]);

        $query->andFilterWhere(['like', 'nombre_completo', $this->nombre_completo])
            ->andFilterWhere(['like', 'idmunicipio', $this->idmunicipio])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
