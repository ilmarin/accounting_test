<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Личная бухгалтерия', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить эту сумму?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'name',
            'amount',
            [
              'attribute' => 'currency_id',              
              'value' => $model->currency['name']                           
            ],
            [
              'attribute' => 'budget_item_id',              
              'value' => $model->budgetItem['name']
            ],
            [
              'attribute' => 'type',              
              'value' => \app\models\Operation::lookupOperationType($model->type)
            ],
            'created:date',            
        ],
    ]) ?>
    
    <p>
        <?= Html::a('Вернуться на главную страницу', ['index']) ?>
    </p>

</div>
