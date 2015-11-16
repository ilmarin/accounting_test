<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Отчет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-form">

  <?php $form = ActiveForm::begin(); ?>    

  <?php
  $options = [
      'clientOptions' => [
          'dateFormat' => 'dd.mm.yyyy',
          'value' => date('d.m.Y')],
      'language' => 'ru',
      'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'maxlength' => '10', 'size' => '10']
  ];
  ?>

  <?= $form->field($model, 'date_from')->widget(DatePicker::className(), $options) ?>
  <?= $form->field($model, 'date_to')->widget(DatePicker::className(), $options) ?>

  <div class="form-group">
    <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

  <?php
  $gridOptions = [
      'dataProvider' => $report['dataProviderExpenses'],
      'emptyText' => 'Нет данных на заданный период',
      'columns' => [
          'name:text:Статья бюджета',
          'amount:text:Сумма',
          'currency:text:Валюта',
      ],
      'showHeader' => false,
      'showFooter' => false,
      'summary' => '<p>Всего в рублях за период: ' . $report['sumExpensesRoubles'] . '</p>' .
      '<p>Всего в долларах за период: ' . $report['sumExpensesDollars'] . '</p>'
  ];
  ?>
  <h1>Список расходов за период</h1>
  <?=
  GridView::widget($gridOptions);
  ?>
  <h1>Список доходов за период</h1>
  <?php $gridOptions['dataProvider'] = $report['dataProviderIncomes']; ?>
  <?php
  $gridOptions['summary'] = '<p>Всего в рублях за период: ' . $report['sumIncomeRoubles'] . '</p>' .
                            '<p>Всего в долларах за период: ' . $report['sumIncomeDollars'] . '</p>'
  ?>

<?= GridView::widget($gridOptions); ?>
</div>
