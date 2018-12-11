<?php

use app\models\Player;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = yii::t('app', 'Packages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-index">

    <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?= Html::a(yii::t('app', 'Create Package'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
//      'id',
      'name',
      [
        'attribute' => 'creator_id',
        'value' => function($model){
          return Player::findOne(['id' => $model->creator_id])->username;
        }
      ],
//            'created_at',
//            'updated_at',

      ['class' => 'yii\grid\ActionColumn'],
    ],
  ]); ?>
</div>
