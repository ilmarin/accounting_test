<?php

namespace app\models;

class ReportForm extends \yii\base\Model
{
    public $date_from;
    public $date_to;
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'date_from' => 'От',
            'date_to' => 'До',            
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_from','date_to'],'required','message' => 'Обязательное поле'],
            ['date_from','date','format' => 'php:d.m.Y','timestampAttribute' => 'date_from', 'message' => 'Ожидается дата в формате ДД.ММ.ГГГГ'],
            ['date_to','date','format' => 'php:d.m.Y','timestampAttribute' => 'date_to', 'message' => 'Ожидается дата в формате ДД.ММ.ГГГГ']
        ];
    }
}

