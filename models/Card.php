<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 19.10.2018
 * Time: 11:22
 */

namespace app\models;


use app\lib\ActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * Class Card
 * @package app\models
 * @property integer $id
 * @property string $question
 * @property string $answer
 */
class Card extends ActiveRecord
{
  public $formName = 'CardForm';

  public static function tableName()
  {
    return '{{%flash_card}}';
  }

  public function formName($newFormName = null)
  {
    if($newFormName) $this->formName = $newFormName;

    return $this->formName;
  }

  public function behaviors()
  {
    return ArrayHelper::merge(parent::behaviors(), [
      'timeStamp' => [
        'class' => TimestampBehavior::class,
      ]
    ]);
  }

  public function rules()
  {
    return [
      [['question', 'answer'], 'required'],
      [['question', 'answer'], 'string', 'max' => 255],
      [['created_at', 'updated_at'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'question' => 'Question',
      'answer' => 'Answer'
    ];
  }

  /**
   * Fills model parameters
   *
   * @param array $attributes
   * @param bool $save
   * @return bool
   */
  public function fill(array $attributes, $save = true): bool
  {
    if ($this->load($attributes, '')) {
      if (($save && $this->save()) || (!$save && $this->validate())) {
        return true;
      }
    }
    return false;
  }

  /**
   * @return array
   */
  public static function getAllCardIds(): array
  {
    $allCards = static::find()->all();
    $ids = [];

    foreach ($allCards as $card) {
      /** @var $card static */
      $ids [] = $card->id;
    }

    return $ids;
  }
}