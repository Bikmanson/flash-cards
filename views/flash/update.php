<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Flash */

$this->title = 'Редактировать Flash: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flash', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="flash-update">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>