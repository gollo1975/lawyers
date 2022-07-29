<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banco;

/**
 * BancoSearch represents the model behind the search form of `app\models\Banco`.
 */
class BancoSearch extends Banco
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idbanco', 'nitbanco', 'entidad', 'direccionbanco', 'telefonobanco', 'producto', 'numerocuenta', 'nitmatricula', 'activo'], 'safe'],
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
        $query = Banco::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['idbanco' => SORT_DESC]] // Agregar esta linea para agregar el orden por defecto
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'idbanco', $this->idbanco])
            ->andFilterWhere(['like', 'nitbanco', $this->nitbanco])
            ->andFilterWhere(['like', 'entidad', $this->entidad])
            ->andFilterWhere(['like', 'direccionbanco', $this->direccionbanco])
            ->andFilterWhere(['like', 'telefonobanco', $this->telefonobanco])
            ->andFilterWhere(['like', 'producto', $this->producto])
            ->andFilterWhere(['like', 'numerocuenta', $this->numerocuenta])
            ->andFilterWhere(['like', 'nitmatricula', $this->nitmatricula])
            ->andFilterWhere(['like', 'activo', $this->activo]);

        return $dataProvider;
    }
}
