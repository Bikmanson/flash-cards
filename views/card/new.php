<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $cards app\forms\CardForm */

$this->title = yii::t('app', yii::t('app', 'Create Card'));
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'cards' => $cards,
    ]) ?>

</div>
