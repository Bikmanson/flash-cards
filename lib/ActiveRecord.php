<?php
namespace app\lib;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ActiveRecord extends \yii\db\ActiveRecord
{
	public function behaviors() {
		try { // ВНИМАНИЕ! КОСТЫЛЬ!
			if( $this->hasAttribute('created_at') || $this->hasAttribute('updated_at') ) {
				return ArrayHelper::merge(parent::behaviors(), [
					TimestampBehavior::class,
				]);
			}
		} catch (\Exception $ex) {}
		return parent::behaviors();
	}

	public function getHiddenFormTokenField() {
		$token = \Yii::$app->getSecurity()->generateRandomString();
		$token = str_replace('+', '.', base64_encode($token));

		\Yii::$app->session->set(\Yii::$app->params['form_token_param'], $token);;
		return Html::hiddenInput(\Yii::$app->params['form_token_param'], $token);
	}

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