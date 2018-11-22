<?php

use app\models\Package;
use app\services\PackageService;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cards';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("
    $(document).ready(function(){
        $('#massDelete').on('click', function(){
            var itemIds = $('#cardGrid').yiiGridView('getSelectedRows');
            if(itemIds.length > 0 && confirm('Are you sure, you want to delete selected cards?')){
                $.ajax({
                    url: '" . Url::to('mass-delete') . "',
                    type: 'post',
                    data: {
                        ids: itemIds
                    }
                });
            }
        });
    });
");
?>
<div class="card-index">

    <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?= Html::a('New Card', ['new'], ['class' => 'btn btn-success']) ?>
      <?= Html::a('Edit', ['edit'], ['class' => 'btn btn-info']) ?>
      <?= Html::button('Delete selected', ['id' => 'massDelete', 'class' => 'btn btn-danger']) ?>
    </p>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'id' => 'cardGrid',
    'columns' => [
      ['class' => 'yii\grid\CheckboxColumn'],

      [
        'attribute' => 'package_id',
        'filter' => PackageService::getMap(),
      ],
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
