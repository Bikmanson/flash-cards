<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Flash */

$this->title = 'Создать Flash';
$this->params['breadcrumbs'][] = ['label' => 'Flash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flash-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>