<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 21.11.2018
 * Time: 15:56
 */

namespace app\models;


use app\lib\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * class PackagePermission
 * @property $id
 * @property $player_id
 * @property $package_id
 * @property $created_at
 * @property $updated_at
 */
class PackagePermission extends ActiveRecord
{
  public static function tableName()
  {
    return '{{%package_permission}}';
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
      [['player_id', 'package_id'], 'required'],
      [['player_id', 'package_id'], 'integer'],
      [['created_at', 'updated_at'], 'integer']
    ];
  }
}