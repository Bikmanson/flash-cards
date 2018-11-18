<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 19.10.2018
 * Time: 11:23
 */

namespace app\lib;


use Yii;
use yii\helpers\ArrayHelper;

class ActiveRecord extends \yii\db\ActiveRecord
{
  public static function createMultiple($modelClass, $multipleModels = [])
  {
    $model = new $modelClass;
    /**
     * @var $model static
     */
    $formName = $model->formName();
    $post = Yii::$app->request->post($formName);
    $models = [];

    if (!empty($multipleModels)) {
      $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
      $multipleModels = array_combine($keys, $multipleModels);
    }

    if ($post && is_array($post)) {
      foreach ($post as $i => $item) {
        if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
          $models[] = $multipleModels[$item['id']];
        } else {
          $models[] = new $modelClass;
        }
      }
    }

    unset($model, $formName, $post);

    return $models;
  }

}