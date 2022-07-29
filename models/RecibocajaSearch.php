<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recibocaja;

/**
 * ReciboCajaSearch represents the model behind the search form of `app\models\Recibocaja`.
 */
class RecibocajaSearch extends Recibocaja
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idrecibo', 'idcliente','autorizado','numero'], 'integer'],
            [['fecharecibo', 'fechapago', 'idtiporecibo', 'idmunicipio', 'valorletras', 'observacion', 'usuariosistema'], 'safe'],
            [['valorpagado'], 'number'],
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
        $query = Recibocaja::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['idrecibo' => SORT_DESC]] // Agregar esta linea para agregar el orden por defecto
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idrecibo' => $this->idrecibo,
            'numero' => $this->numero,
            'fecharecibo' => $this->fecharecibo,
            'fechapago' => $this->fechapago,
            'valorpagado' => $this->valorpagado,
            'idcliente' => $this->idcliente,
            'autorizado' => $this->autorizado,
        ]);

        $query->andFilterWhere(['like', 'idtiporecibo', $this->idtiporecibo])
            ->andFilterWhere(['like', 'idmunicipio', $this->idmunicipio])
            ->andFilterWhere(['like', 'valorletras', $this->valorletras])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'usuariosistema', $this->usuariosistema]);

        return $dataProvider;
    }
}
