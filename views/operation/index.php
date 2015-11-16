<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Личная бухгалтерия';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
    <?= Html::a('Добавить сумму', ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?=
  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'summary' => '',
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'name',
          'amount',
          [
              'attribute' => 'currency_id',              
              'content' => function($data) {
                  return $data->currency['name'];
              },
              'filter' => app\models\Currency::getCurrencyList()
          ],
          [
              'attribute' => 'budget_item_id',              
              'content' => function($data) {
                  return $data->budgetItem['name'];
              },
              'filter' => app\models\BudgetItem::getBudgetItemList()
          ],
          [
              'attribute' => 'type',              
              'content' => function($data) {
                  $text = $data->type ? 'income' : 'expense';           
                  return "<div class=\"$text\"></div>";                     
              },                            
              'contentOptions' => ['class' => 'budget-cell'],
              'filterOptions' => ['prompt' => 'Выбор'],
              'filter' => \app\models\Operation::getOperationTypeLabels(),              
          ],
          'created:date',
          // 'updated',
          ['class' => 'yii\grid\ActionColumn'],                          
      ],
  ]);
  ?>
</div>
