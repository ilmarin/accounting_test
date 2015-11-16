<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BudgetItem */

$this->title = 'Добавить статью бюджета';
$this->params['breadcrumbs'][] = ['label' => 'Добавить статью бюджета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
