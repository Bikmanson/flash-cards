<?php

namespace modules\lang\common\models;

use Yii;

/**
 * This is the model class for table "{{%lang}}".
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property string $ietf_tag
 * @property int $is_default
 * @property int $created_at
 * @property int $updated_at
 */
class Lang extends \app\lib\ActiveRecord
{
  /**
   * @inheritdoc
   * @return LangQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new LangQuery(get_called_class());
  }

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return '{{%lang}}';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'is_default', 'created_at', 'updated_at'], 'integer'],
      [['name', 'label', 'ietf_tag'], 'string', 'max' => 64],
      [['id'], 'unique'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'name' => 'Name',
      'label' => 'Label',
      'ietf_tag' => 'Ietf Tag',
      'is_default' => 'Is Default',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  /**
   * Переменная, для хранения текущего объекта языка
   * @var array|null|self
   */
  static $current = null;

  /**
   * Получение текущего объекта языка
   * @return array|null|self
   */
  static function getCurrent()
  {
    if (self::$current === null) {
      self::$current = self::getDefaultLang();
    }
    return self::$current;
  }

  /**
   * Установка текущего объекта языка и локаль пользователя
   * @param null|string $url
   */
  static function setCurrent($url = null)
  {
    $language = self::getLangByUrl($url);
    self::$current = ($language === null) ? self::getDefaultLang() : $language;
    Yii::$app->language = self::$current->locale;
    Yii::$app->params['dateControlDisplay'][\kartik\datecontrol\Module::FORMAT_DATE] = self::$current->date_format;
    Yii::$app->params['dateControlDisplay'][\kartik\datecontrol\Module::FORMAT_DATETIME] = self::$current->datetime_format;
    Yii::$app->params['dateControlDisplay'][\kartik\datecontrol\Module::FORMAT_TIME] = self::$current->time_format;
  }

  protected static $_defaultLang;

  /**
   * Получения объекта языка по умолчанию
   * @return array|null|\yii\db\ActiveRecord
   */
  static function getDefaultLang()
  {
    if (isset(self::$_defaultLang))
      return self::$_defaultLang;
    return self::$_defaultLang = Lang::find()->where('`is_default` = :default', [':default' => 1])->one();
  }

  protected static $_defaultLangId;

  /**
   * Получения объекта языка по умолчанию
   * @return array|null|\yii\db\ActiveRecord
   */
  static function getDefaultLangId()
  {
    if (isset(self::$_defaultLangId)) {
      return self::$_defaultLangId;
    }
    return self::$_defaultLangId = self::getDefaultLang()->id;
  }

  /**
   * Получения объекта языка по буквенному идентификатору
   * @param null|string $url
   * @return array|null|\yii\db\ActiveRecord
   */
  static function getLangByUrl($url = null)
  {
    if ($url === null) {
      return null;
    } else {
      $language = Lang::find()->where('url = :url', [':url' => $url])->one();
      if ($language === null) {
        return null;
      } else {
        return $language;
      }
    }
  }
}
