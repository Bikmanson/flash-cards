<?php

namespace modules\lang;

use Yii;

class Module extends \common\lib\Module
{
  public $controllerNamespace = 'app\modules\lang\backend\controllers';

  public function init()
  {
    parent::init();
    $this->registerTranslations();
  }

  public function registerTranslations()
  {
    Yii::$app->i18n->translations['modules/lang/*'] = [
      'class' => 'yii\i18n\PhpMessageSource',
      'sourceLanguage' => 'en-US',
      'basePath' => '@modules/lang/messages',
      'fileMap' => [
        'modules/lang/attributeLabels' => 'attributeLabels.php',
      ]
    ];
  }

  public static function t($category, $message, $params = [], $language = null)
  {
    return Yii::t('modules/lang/' . $category, $message, $params, $language);
  }
}