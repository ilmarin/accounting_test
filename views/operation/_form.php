<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'name')->textInput(['maxlength' => true]) ?>
  
    <?= $form->field($model,'created')->widget('yii\jui\DatePicker',['clientOptions' => ['dateFormat' => 'dd.mm.yyyy', 'value' => date('d.m.Y')], 'language' => 'ru', 'options' => ['class' => 'form-control', 'autocomplete' => 'off']]) ?>
  
    <?= $form->field($model,'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'currency_id')->dropDownList(app\models\Currency::getCurrencyList()) ?>
  
    <?= $form->field($model,'budget_item_id')->dropDownList(app\models\BudgetItem::getBudgetItemList()) ?>
  
    <?= $form->field($model,'type')->radioList(\app\models\Operation::getOperationTypeLabels()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
