<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $customBtns array */

/* @var $cards array of objects */
/* @var $edit bool|null dynamic form widget bug fix */
?>

<div class="card-form">

  <?php $form = ActiveForm::begin([
    'id' => 'newCard'
  ]); ?>

    <?php
    ($edit) ? $limit = 1 : $limit = 999; //dynamic form widget bug fix
    ?>
    <?php DynamicFormWidget::begin([
      'widgetContainer' => 'cardsDynamicForm_wrapper',
      'widgetBody' => '.b-cards',
      'widgetItem' => '.b-cards__item',
      'min' => 1,
      'limit' => $limit,
      'insertButton' => '.b-cards__item-btn_add',
      'deleteButton' => '.b-cards__item-btn_delete',
      'model' => $cards[0],
      'formId' => 'newCard',
      'formFields' => [
        'question',
        'answer'
      ]
    ]) ?>

    <?php foreach ($cards as $index => $card): ?>

          <div class="b-cards b-card-form__cards">
              <div class="b-cards__item">
                <?php
                /** @var $card \app\models\Card */
                if (!$card->isNewRecord) {
                  echo Html::activeHiddenInput($card, "[{$index}]id");
                }
                ?>

                <?= $form->field($card, "[{$index}]question")->textInput(['class' => 'b-cards__item-input']) ?>
                <?= $form->field($card, "[{$index}]answer")->textInput(['class' => 'b-cards__item-input']) ?>
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
