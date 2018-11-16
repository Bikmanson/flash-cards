<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $cardForm app\forms\CardForm */

$this->title = 'Edit Card: ' . $cardForm->cardId;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cardForm->cardId, 'url' => ['view', 'id' => $cardForm->cardId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="card-update">

    <h1><?= Html::encode($this->title) ?></h1>

  <?php
  $deleteBtn = Html::a('Delete card', ['delete', 'id' => $cardForm->card->id], [
    'class' => 'btn btn-danger',
    'data' => [
      'confirm' => 'Are you sure you want to delete this item?',
      'method' => 'post',
    ],
  ]);
  $customBtns [] = $deleteBtn;
  ?>

  <?= $this->render('_form', [
    'cardForm' => $cardForm,
    'customBtns' => $customBtns
  ]) ?>

</div>
