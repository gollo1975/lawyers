<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoRecibo;

/**
 * TipoReciboSearch represents the model behind the search form of `app\models\TipoRecibo`.
 */
class TipoReciboSearch extends TipoRecibo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idtiporecibo', 'concepto'], 'safe'],
            [['activo'], 'integer'],
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
        $query = TipoRecibo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['concepto' => SORT_ASC]] // Agregar esta linea para agregar el orden por defecto
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'idtiporecibo', $this->idtiporecibo])
            ->andFilterWhere(['like', 'concepto', $this->concepto]);

        return $dataProvider;
    }
}
