<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "Operation".
 *
 * @property integer $id
 * @property string $name
 * @property string $amount
 * @property integer $currency_id
 * @property integer $created
 * @property integer $updated
 */
class Operation extends ActiveRecord {

    const STATUS_INCOME = 1;
    const STATUS_EXPENSE = 0;        

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ytp_operation';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['currency_id', 'budget_item_id', 'type', 'updated'], 
                'integer', 'message' => 'Должно быть целым числом'],
            ['created', 'date', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'created','message' => 'Дата в формате ДД.ММ.ГГГГ'],
            ['amount', 'double', 'message' => 'Должно быть числом'],
            [['name'], 'string', 'max' => 250, 'message' => 'Не более 250 символов']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'amount' => 'Сумма',
            'currency_id' => 'Валюта',
            'budget_item_id' => 'Статья бюджета',
            'created' => 'Дата операции',
            'updated' => 'Обновлено',
            'type' => 'Тип операции'
        ];
    }

    public function afterFind() {
        parent::afterFind();

        $this->amount = $this->getFormattedAmount();
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }

    /**
     * Перед сохранением переводим сумму в integer и дату в unixtime
     * @return boolean
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->amount) {
                $this->amount = $this->getIntegerAmount();
            }
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency() {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItem() {
        return $this->hasOne(BudgetItem::className(), ['id' => 'budget_item_id']);
    }

    /**
     * Массив подписей для типа расход/доход
     * 
     * @return array
     */
    public static function getOperationTypeLabels() {
        return [1 => 'Доход', 0 => 'Расход'];
    }

    /**
     * Возвращает данные для отчета
     * 
     * @param integer $date_from
     * @param integer $date_to
     * @return array
     */
    public static function getReportInfo($date_from, $date_to) {

        $result['dataProviderExpenses'] = self::getReportDataProvider($date_from, $date_to, Operation::STATUS_EXPENSE);

        $result['dataProviderIncomes'] = self::getReportDataProvider($date_from, $date_to, Operation::STATUS_INCOME);
        
        $expenses = $result['dataProviderExpenses']->getModels();

        $result['sumExpensesDollars'] = self::getTotalOperationsSum($expenses, Currency::CURRENCY_USD);
        $result['sumExpensesRoubles'] = self::getTotalOperationsSum($expenses, Currency::CURRENCY_RUB);
        
        $income = $result['dataProviderIncomes']->getModels();
        
        $result['sumIncomeDollars'] = self::getTotalOperationsSum($income, Currency::CURRENCY_USD);
        $result['sumIncomeRoubles'] = self::getTotalOperationsSum($income, Currency::CURRENCY_RUB);
        
        return $result;
    }
    
    /**
     * Возвращает сумму расходов или доходов для отчета operation/report
     * за заданный период.
     * 
     * @param integer $date_from
     * @param integer $date_to
     * @param integer $operation_type
     * @return \yii\data\SqlDataProvider
     */
    protected static function getReportDataProvider($date_from, $date_to, $operation_type) {
        return new \yii\data\SqlDataProvider([
            'sql' =>
                'SELECT CAST(sum(`amount`)/'.self::getMultiplier().' as DECIMAL(20,2)) as `amount`, cc.`name` as `currency`, cc.id as `currency_id`, b.`name` as `name` '.
                'FROM ytp_operation o '.
                'INNER JOIN ytp_currency cc ON(o.currency_id = cc.id) '.
                'INNER JOIN ytp_budget_item b ON(o.budget_item_id = b.id) '.
                'WHERE o.created BETWEEN :date_from AND :date_to AND o.`type` = :type '.                
                'GROUP BY b.name, o.type',
            'params' => [                
                ':date_from' => $date_from,
                ':date_to' => $date_to,
                ':type' => $operation_type,
            ],                
        ]);
    }
    
    /**
     * Подсчет суммы операций по валюте
     * 
     * @param array $models Строки для подсчета
     * @param integer $currency Для какой валюты считать итоги (рубли, доллары)
     * @return double
     */
    protected static function getTotalOperationsSum($models, $currency) {
        $sum = 0.00;        
        foreach ($models as $model) {
            if ($currency == $model['currency_id']) {
             $sum += floatval($model['amount']);   
            }            
        }
        
        return $sum;
    }

    /**
     * Возвращает подпись для типа строки бюджета по коду
     * 
     * @param integer $id
     * @return string
     */
    public static function lookupOperationType($id) {
        $values = self::getOperationTypeLabels();

        return $values[$id] ? : 'Неизвестно';
    }

    /**
     * Преобразует сумму работы с БД
     * 
     * @return integer
     */
    protected function getIntegerAmount() {
        $floatval = floatval($this->amount);
        return $floatval * self::getMultiplier();
    }

    /**
     * Преобразует сумму для отображения на странице
     * 
     * @return string
     */
    protected function getFormattedAmount() {
        $number = floatval($this->amount / self::getMultiplier());

        return ($number) ? number_format($number, 2, '.', '') : '0';
    }

    /**
     * Возвращает множитель для обработки числа перед сохранинием в БД,
     * либо перед отображением.
     * 
     * @return integer
     */
    public static function getMultiplier() {
        return Yii::$app->params['multiplier'];
    }

}
