<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CompraTipo;

/**
 * CompraTipoSearch represents the model behind the search form of `app\models\CompraTipo`.
 */
class CompraTipoSearch extends CompraTipo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_compra_tipo'/*, 'cuenta'*/], 'integer'],
            [['tipo'], 'safe'],
            //[['porcentaje'], 'number'],
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
        $query = CompraTipo::find();

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
            'id_compra_tipo' => $this->id_compra_tipo,
            //'porcentaje' => $this->porcentaje,
            //'cuenta' => $this->cuenta,
        ]);

        $query->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }
}
