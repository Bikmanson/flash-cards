<?php

use yii\helpers\Html;
use modules\lang\widgets\langActiveForm\ActiveForm;
use backend\widgets\crudActions\CrudActions;

/* @var $this yii\web\View */
/* @var $model app\models\Flash */
/* @var $form backend\widgets\langActiveForm\LangActiveForm */

?>

<div class="flash-form">

  <?php $form = ActiveForm::begin([
  'defaultLangInd' => $model->getDefaultLangInd(),
  ]); ?>

  <div class="m-portlet__head">
    <div class="m-portlet__head-caption">
      <?= CrudActions::widget(["model" => $model, "template" => "{index}"]) ?>
    </div>
    <div class="m-portlet__head-tools">
      <ul class="m-portlet__nav">
        <li class="m-portlet__nav-item">
          <?= Html::dropDownList(null, $model->getDefaultLangInd(), $model->getLangMap(), [
          'class' => 'form-control',
          'id' => 'lang-dropdown',
          ]) ?>
        </li>
        <li class="m-portlet__nav-item">
          <?= CrudActions::widget(['model' => $model,]); ?>
        </li>
      </ul>
    </div>
  </div>
  <div class="m-portlet__body">
    <div class="row">
      <div class="col-xl-8 offset-xl-2">
          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'id')->textInput() ?>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model->variationModels, 'question')->textarea(['rows' => 6]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model->variationModels, 'answer')->textarea(['rows' => 6]) ?>
            </div>
          </div>
      </div>
    </div>
    <?php ActiveForm::end(); ?>

  </div>
</div>