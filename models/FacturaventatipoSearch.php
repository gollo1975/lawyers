<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Facturaventatipo;

/**
 * FacturaventatipoSearch represents the model behind the search form of `app\models\Facturaventatipo`.
 */
class FacturaventatipoSearch extends Facturaventatipo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_factura_venta_tipo', 'estado'], 'integer'],
            [['porcentaje_retefuente'], 'number'],
            [['concepto'], 'safe'],
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
        $query = Facturaventatipo::find();

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
            'id_factura_venta_tipo' => $this->id_factura_venta_tipo,
            'estado' => $this->estado,
            'porcentaje_retefuente' => $this->porcentaje_retefuente,
        ]);

        $query->andFilterWhere(['like', 'concepto', $this->concepto]);

        return $dataProvider;
    }
}
