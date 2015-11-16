<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Operation;

/**
 * OperationSearch represents the model behind the search form about `app\models\Operation`.
 */
class OperationSearch extends Operation {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [            
            [['id', 'currency_id', 'budget_item_id', 'type', 'updated'], 'integer','message' => 'Ожидается целое число'],
            ['amount','double','message' => 'Ожидается число'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Operation::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }
        
        if ($this->amount) {
          $this->amount = $this->getIntegerAmount($this->amount);   
        }        

        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'currency_id' => $this->currency_id,
            'budget_item_id' => $this->budget_item_id,  
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        
        $query->orderBy('created');
        
        if ($this->amount) {
          $this->amount = $this->getFormattedAmount();   
        }            

        return $dataProvider;
    }

}
