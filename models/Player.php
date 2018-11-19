<?php

namespace app\models;

use app\lib\ActiveRecord;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%player}}".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $authKey
 */
class Player extends ActiveRecord implements IdentityInterface
{
  public function __construct(array $config = [])
  {
    $this->authKey = Yii::$app->security->generateRandomString();

    parent::__construct($config);
  }

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return '{{%player}}';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['username', 'password_hash', 'authKey'], 'required'],
      [['username'], 'string', 'max' => 20],
      [['password_hash', 'authKey'], 'string', 'max' => 255],
      [['username'], 'unique'],
      [['password_hash'], 'unique'],
      [['authKey'], 'unique'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'username' => 'Username',
    ];
  }

  /**
   * Finds an identity by the given ID.
   * @param string|int $id the ID to be looked for
   * @return IdentityInterface the identity object that matches the given ID.
   * Null should be returned if such an identity cannot be found
   * or the identity is not in an active state (disabled, deleted, etc.)
   */
  public static function findIdentity($id)
  {
    $result = self::findOne(['id' => $id]);
    return $result ? $result : null;
  }

  /**
   * Doesn't support access token attribute
   * @throws NotSupportedException
   */
  public static function findIdentityByAccessToken($token, $type = null)
  {
    throw new NotSupportedException('Player doesn\'t support access token attribute');
  }

  /**
   * Returns an ID that can uniquely identify a user identity.
   * @return string|int an ID that uniquely identifies a user identity.
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Returns a key that can be used to check the validity of a given identity ID.
   *
   * The key should be unique for each individual user, and should be persistent
   * so that it can be used to check the validity of the user identity.
   *
   * The space of such keys should be big enough to defeat potential identity attacks.
   *
   * This is required if [[User::enableAutoLogin]] is enabled.
   * @return string a key that is used to check the validity of a given identity ID.
   * @see validateAuthKey()
   */
  public function getAuthKey()
  {
    return $this->authKey;
  }

  /**
   * Validates the given auth key.
   *
   * This is required if [[User::enableAutoLogin]] is enabled.
   * @param string $authKey the given auth key
   * @return bool whether the given auth key is valid.
   * @see getAuthKey()
   */
  public function validateAuthKey($authKey)
  {
    return $this->authKey === $authKey;
  }

  public static function findByUsername($username)
  {
    return self::findOne(['username' => $username]);
  }

  public function validatePassword($password)
  {
    return Yii::$app->security->validatePassword($password, $this->password_hash);
  }

  public function setPassword($password)
  {
    $this->password_hash = Yii::$app->security->generatePasswordHash($password);
  }
}
