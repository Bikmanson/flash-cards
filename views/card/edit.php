<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $cards array of Card objects */

count($cards) === 1 ? $oneCard = true : $oneCard = false;
$cardId = false;

if($oneCard){
  $cardId = $cards[0]->id;
  $this->title = 'Edit Card: ' . $cardId;
} else {
  $this->title = 'Edit Cards';
}

$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card-update">

    <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'cards' => $cards,
    'edit' => true //dynamic form widget bug fix
  ]) ?>

</div>
