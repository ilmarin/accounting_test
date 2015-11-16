<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */

$this->title = 'Редактирование суммы: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Личная бухгалтерия', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="operation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
