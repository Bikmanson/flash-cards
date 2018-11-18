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
  public static function tableName()
  {
    return '{{%flash_card}}';
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
   * @param bool $validate
   * @param bool $save
   * @return bool
   */
  public function fill(array $attributes, $validate = true, $save = true): bool
  {
    if ($this->load($attributes, '')) {
      if (($save && $this->save($validate)) || (!$save && $validate ? $this->validate() : true)) {
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

  public static function prepareMultiple(array $data, array $existingCards = [], $oldIds = null): array
  {
    $answer = [];

    if ($data) {
      $cards = Card::createMultiple(static::class, $existingCards);

      if($existingCards){
        $oldIds = ArrayHelper::map($existingCards, 'id', 'id');
      }

      if (Card::loadMultiple($cards, $data) && Card::validateMultiple($cards)) {
        $newIds = ArrayHelper::map($cards, 'id', 'id');
        $answer['deletedIds'] = array_diff($oldIds, $newIds);
        $answer['cards'] = $cards;
      }
    }

    return $answer;
  }
}