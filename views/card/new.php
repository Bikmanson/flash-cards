<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $cardForms app\forms\CardForm */

$this->title = 'Create Card';
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'cardForms' => $cardForms,
    ]) ?>

</div>
