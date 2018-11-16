<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\db\Exception;


class ActionRenameBehavior extends Behavior
{
  public $newNamesArr;

  public function __construct(array $config = [])
  {
    parent::__construct($config);

//    if ($this->newNamesArrValidation($this->newNamesArr)) { //todo: to activate it
      $this->newNamesArr = $this->generateNewActionNames($this->newNamesArr);
//    }
  }

  public function __call($name, $params)
  {
    if ($action = $this->newNamesArr[$name]) { // todo: doesn't call this method
      $this->owner->$action($params);
    } else {
      parent::__call($name, $params);
    }
  }

  private function newNamesArrValidation($newNamesArr)
  {
    foreach ($newNamesArr as $requestAction => $existingAction) {
      $existingAction = 'action' . ucfirst($existingAction);

      if (!function_exists($this->owner->$existingAction)) { // todo: doesn't see $owner variable
        throw new Exception('ActionRenameBehavior: Not valid array with new action names is received');
      }
    }

    return true;
  }

  private function generateNewActionNames($newNamesArr)
  {
    $newArr = [];

    foreach ($newNamesArr as $requestAction => $existingAction) {
      $requestAction = 'action' . ucfirst($requestAction);
      $existingAction = 'action' . ucfirst($existingAction);

      $newArr[] = [$requestAction => $existingAction];
    }

    return $newArr;
  }
}