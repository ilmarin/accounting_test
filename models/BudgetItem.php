<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budget_item".
 *
 * @property integer $id
 * @property string $name
 */
class BudgetItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ytp_budget_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name','required','message' => 'Обязательное поле'],
            [['name'], 'string', 'max' => 200, 'message' => 'Не более 200 символов']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название статьи',
        ];
    }
    
    /**
     * Список статей бюджета для фильтра
     * 
     * @return array
     */    
    public static function getBudgetItemList()
    {
        $currencies = BudgetItem::find()->select(['id', 'name'])->all();
        return \yii\helpers\ArrayHelper::map($currencies, 'id', 'name');
    }        
}
