<?php

namespace app\models;

use app\services\PackageService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%package}}".
 *
 * @property int $id
 * @property string $name
 * @property int $creator_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Card[] $cards
 * @property Player $creator
 */
class Package extends \app\lib\ActiveRecord
{
  const DEFAULT_PACKAGE_NAME = 'default';

  const EVENT_AFTER_NEW_INSTANCE = 'afterNewInstance';

  public function __construct(array $config = [])
  {
    $this->on(self::EVENT_AFTER_NEW_INSTANCE, function ($event) {
      $event->sender->creator_id = Yii::$app->user->identity->getId();
    });
    $this->on(static::EVENT_AFTER_INSERT, function ($event) {
      if (!PackageService::areAllowed([$event->sender->id])) {
        PackageService::permit($event->sender->creator_id, $event->sender->id);
      }
    });

    parent::__construct($config);
  }

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return '{{%package}}';
  }

  public function behaviors()
  {
    return ArrayHelper::merge(parent::behaviors(), [
      'timeStamp' => [
        'class' => TimestampBehavior::class,
      ]
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['creator_id', 'name'], 'required'],
      [['creator_id', 'created_at', 'updated_at'], 'integer'],
      [['name'], 'string', 'max' => 50],
      [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Player::className(), 'targetAttribute' => ['creator_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => yii::t('app', 'ID'),
      'name' => yii::t('app', 'Name'),
      'creator_id' => yii::t('app', 'Creator'),
      'created_at' => yii::t('app', 'Created At'),
      'updated_at' => yii::t('app', 'Updated At'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCards()
  {
    return $this->hasMany(Card::className(), ['package_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCreator()
  {
    return $this->hasOne(Player::className(), ['id' => 'creator_id']);
  }

  public function afterNewInstance()
  {
    $this->trigger(self::EVENT_AFTER_NEW_INSTANCE);
  }
}
