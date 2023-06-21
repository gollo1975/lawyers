<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ComprobanteEgreso;

/**
 * ComprobanteEgresoSearch represents the model behind the search form of `app\models\ComprobanteEgreso`.
 */
class ComprobanteEgresoSearch extends ComprobanteEgreso
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_comprobante_egreso', 'numero', 'id_comprobante_egreso_tipo', 'id_proveedor', 'estado', 'autorizado', 'libre', 'id_banco'], 'integer'],
            [['id_municipio', 'fecha', 'fecha_comprobante', 'observacion', 'usuariosistema'], 'safe'],
            [['valor'], 'number'],
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
        $query = ComprobanteEgreso::find();

        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_comprobante_egreso' => SORT_DESC]] // Agregar esta linea para agregar el orden por defecto
        ]);        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_comprobante_egreso' => $this->id_comprobante_egreso,
            'fecha' => $this->fecha,
            'fecha_comprobante' => $this->fecha_comprobante,
            'numero' => $this->numero,
            'id_comprobante_egreso_tipo' => $this->id_comprobante_egreso_tipo,
            'valor' => $this->valor,
            'id_proveedor' => $this->id_proveedor,
            'estado' => $this->estado,
            'autorizado' => $this->autorizado,
            'libre' => $this->libre,
            'id_banco' => $this->id_banco,
        ]);

        $query->andFilterWhere(['like', 'id_municipio', $this->id_municipio])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'usuariosistema', $this->usuariosistema]);

        return $dataProvider;
    }
}
