<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%package}}".
 *
 * @property int $id
 * @property string $name
 * @property int $creator_id
 * @property int $allowance_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Card[] $cards
 * @property Player $creator
 */
class Package extends \app\lib\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return '{{%package}}';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['creator_id', 'allowance_id', 'created_at', 'updated_at'], 'integer'],
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
      'creator_id' => 'Creator ID',
      'allowance_id' => 'Allowance',
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
