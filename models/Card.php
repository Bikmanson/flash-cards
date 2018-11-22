<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 19.10.2018
 * Time: 11:22
 */

namespace app\models;


use app\lib\ActiveRecord;
use app\services\CardService;
use app\services\PackageService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

/**
 * Class Card
 * @package app\models
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property string $player_id
 * @property string $package_id
 */
class Card extends ActiveRecord
{
  public function __construct(array $config = [])
  {
    $this->player_id = Yii::$app->user->identity->getId();
    parent::__construct($config);
  }

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
      [['question', 'answer', 'player_id'], 'required'],
      [['question', 'answer'], 'string', 'max' => 255],
      ['package_id', 'integer', 'max' => 11],
      ['player_id', 'integer', 'max' => 11],
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
   * @param array $packageIds
   * @return array
   * @throws BadRequestHttpException
   */
  public static function getAllCardIds(array $packageIds = []): array
  {
    $allCards = [];

    if (empty($packageIds)) {
      $allCards = CardService::getCards();
    } else {
      $allCards = CardService::getCards($packageIds);
    }
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

      if ($existingCards) {
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

  public function getPlayer()
  {
    return $this->hasOne(Player::class, ['id' => 'player_id']);
  }
}