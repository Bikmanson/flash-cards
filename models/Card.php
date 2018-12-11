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
 * @property string $creator_id
 * @property string $package_id
 * @property string $created_at
 * @property string $updated_at
 */
class Card extends ActiveRecord
{
  public function __construct(array $config = [])
  {
    $this->creator_id = Yii::$app->user->identity->getId();
    $this->on(static::EVENT_BEFORE_VALIDATE, function () {
      if (!$this->package_id) {
        $this->package_id = Package::findOne([
          'creator_id' => Yii::$app->user->getId(),
          'name' => Package::DEFAULT_PACKAGE_NAME
        ])->id;
      }
    });
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
      [['question', 'answer', 'creator_id', 'package_id'], 'required', 'when' => function () {
        return true;
      }, 'whenClient' => 'function(){return false}'],
      [['question', 'answer'], 'string', 'max' => 255],
      ['package_id', 'integer'],
      ['creator_id', 'integer'],
      [['created_at', 'updated_at'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'question' => yii::t('app', 'Question'),
      'answer' => yii::t('app', 'Answer'),
      'creator_id' => yii::t('app', 'Author'),
      'package_id' => yii::t('app', 'Package')
    ];
  }

  public static function prepareMultiple(array $data, array $existingCards = [], $oldIds = null): array
  {
    $answer = [];

    if ($data) {
      $cards = Card::createMultiple(static::class, $existingCards);

      if ($existingCards) {
        $answer['oldIds'] = ArrayHelper::map($existingCards, 'id', 'id');
      }

      if (Card::loadMultiple($cards, $data)) {
        CardService::defaultPacking($cards);

        if (Card::validateMultiple($cards)) {
          $answer['cards'] = $cards;
        }
      }
    }

    return $answer; // ['oldIds' => [...], 'cards' => [...]]
  }

  public function getCreator()
  {
    return $this->hasOne(Player::class, ['id' => 'creator_id']);
  }
}