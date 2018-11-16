<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $cardForms array of objects */
/* @var $form yii\widgets\ActiveForm */
/* @var $customBtns array */
?>

<div class="card-form">

  <?php $form = ActiveForm::begin([
    'id' => 'newCardForm'
  ]); ?>

  <?php DynamicFormWidget::begin([
    'widgetContainer' => 'cardsDynamicForm_wrapper',
    'widgetBody' => '.b-cards',
    'widgetItem' => '.b-cards__item',
    'min' => 1,
    'insertButton' => '.b-cards__item-btn_add',
    'deleteButton' => '.b-cards__item-btn_delete',
    'model' => $cardForms[0],
    'formId' => 'newCardForm',
    'formFields' => [
      'question',
      'answer'
    ]
  ]) ?>

  <?php foreach ($cardForms as $index => $cardForm): ?>

      <div class="b-cards b-card-form__cards">
          <div class="b-cards__item">
            <?= $form->field($cardForm, "[{$index}]question")->textInput(['class' => 'b-cards__item-input']) ?>
            <?= $form->field($cardForm, "[{$index}]answer")->textInput(['class' => 'b-cards__item-input']) ?>
              <div class="b-cards__item-btns">
                  <div class="b-cards__item-btn_add">+</div>
                  <div class="b-cards__item-btn_delete">-</div>
              </div>
          </div>
      </div>

  <?php endforeach ?>

  <?php DynamicFormWidget::end() ?>

    <div class="form-group">
      <?php
      if ($customBtns) {
        foreach ($customBtns as $btn) {
          echo $btn;
        }
      }
      ?>
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

  <?php ActiveForm::end(); ?>

</div>
