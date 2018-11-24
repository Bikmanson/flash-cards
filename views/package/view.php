<?php

use app\models\Player;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Package */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
          'confirm' => 'Are you sure you want to delete this item?',
          'method' => 'post',
        ],
      ]) ?>
    </p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      'name',
      [
        'attribute' => 'creator_id',
        'value' => function($model){
          return Player::findOne(['id' => $model->creator_id])->username;
        }
      ]
//            'created_at',
//            'updated_at',
    ],
  ]) ?>

</div>
