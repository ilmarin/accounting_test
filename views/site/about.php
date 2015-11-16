<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Описание';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Вроде все условия выполнил и ничего не забыл.                       
    </p>
    
    <p>
      Модели и CRUD сгенерировал в Gii, затем отредактировал.
    </p>
    
    <p>
      Суммы хранятся в БД с типов integer, даты в unixtimestamp.
    </p>
    
    <p>
      Тесты прилагаются.
    </p>

    <code><?= __FILE__ ?></code>
</div>