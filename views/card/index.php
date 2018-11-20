<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-index">

    <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?= Html::a('New Card', ['new'], ['class' => 'btn btn-success']) ?>
      <?= Html::a('Edit', ['edit'], ['class' => 'btn btn-info']) ?>
    </p>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'question:ntext',
      'answer:ntext',

      [
        'class' => 'app\lib\ActionColumn',
        'urlCreator' => function ($action, $model, $key, $index) {
          if ($action === 'view') {
            return Url::to(['view', 'id' => $model->id]);
          }
          if ($action === 'update') {
            return Url::to(['edit', 'id' => $model->id]);
          }
          if ($action === 'delete') {
            return Url::to(['delete', 'id' => $model->id]);
          }
        }
      ],
    ],
  ]); ?>
</div>
