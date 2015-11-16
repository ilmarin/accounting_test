<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $name
 */
class Currency extends \yii\db\ActiveRecord
{
    const CURRENCY_RUB = 3;
    const CURRENCY_USD = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ytp_currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name','required','message' => 'Обязателное поле'],
            [['name'], 'string', 'max' => 50, 'message' => 'Максимум 50 символов']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Валюта',
        ];
    }
    
    public static function getCurrencyList()
    {
        $currencies = Currency::find()->select(['id', 'name'])->all();
        return \yii\helpers\ArrayHelper::map($currencies, 'id', 'name');
    }
}
