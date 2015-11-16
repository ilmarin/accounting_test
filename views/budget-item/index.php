<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BudgetItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи бюджета';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить статью бюджета', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
          
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'summary' => ''
    ]); ?>

</div>
