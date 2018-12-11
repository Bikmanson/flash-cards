<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel modules\lang\common\models\LangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Langs';
$this->params['breadcrumbs'][] = $this->title;
$this->params['actions'] = [
    [
        'label' => 'Создать',
        'url' => Url::to(['create']),
        'type' => 'success',
        'icon' => 'la la-plus'
    ]
];
?>
<div class="lang-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'label',
            'ietf_tag',
            'is_default',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
