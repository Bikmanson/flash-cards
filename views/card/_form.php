<?php

use app\models\Package;
use app\services\PackageService;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $customBtns array */

/* @var $cards array of objects */
/* @var $edit bool|null dynamic form widget bug fix */

\app\assets\CardAsset::register($this);
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
      'answer',
      'player_id'
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

            <?= $form->field($card, "[{$index}]package_id")->dropDownList(PackageService::getMap(), ['prompt' => 'Packages...']) ?>

            <?= $form->field($card, "[{$index}]question")->textarea(['class' => 'b-cards__item-text', 'rows' => 5])
              ->label($card->getAttributeLabel('question'), ['class' => 'b-cards__item-label b-cards__item-label_question']) ?>

            <?= $form->field($card, "[{$index}]answer")->textarea(['class' => 'b-cards__item-text', 'rows' => 5]
            )->label($card->getAttributeLabel('answer'), ['class' => 'b-cards__item-label b-cards__item-label_answer']) ?>

              <div class="b-cards__item-btns">
                  <div class="b-cards__item-btn b-cards__item-btn_add btn btn-success">+</div>
                  <div class="b-cards__item-btn b-cards__item-btn_delete btn btn-danger">-</div>
              </div>
              <hr class="b-cards__item-hr">
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
      <?= Html::submitButton(yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

  <?php ActiveForm::end(); ?>

</div>
