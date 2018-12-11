<?php

namespace modules\lang\lib;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CheckboxColumn extends \yii\grid\CheckboxColumn
{
  public $checkboxOptions = [
    'label' => '<span></span>',
    'labelOptions' => ['class'=>'m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand'],
    'options' => ['class' => 'm-group-checkable'],
  ];

  protected function renderHeaderCellContent()
  {
    if ($this->header !== null || !$this->multiple) {
      return parent::renderHeaderCellContent();
    }

    return Html::checkbox($this->getHeaderCheckBoxName(), false, ArrayHelper::merge($this->checkboxOptions, ['class' => 'select-on-check-all']));
  }
}