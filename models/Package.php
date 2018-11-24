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

  public function __construct(array $config = [])
  {
    $this->creator_id = Yii::$app->user->identity->getId();

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

  public function afterSave($insert, $changedAttributes)
  {
    parent::afterSave($insert, $changedAttributes);

    if (!PackageService::areAllowed([$this->id])) {
      PackageService::permit($this->creator_id, $this->id); // todo: doesn't work
    }
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
      'id' => 'ID',
      'name' => 'Name',
      'creator_id' => 'Creator',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
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
}
