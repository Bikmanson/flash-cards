<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 21.11.2018
 * Time: 15:56
 */

namespace app\models;


use app\lib\ActiveRecord;

/**
 * class PackageAllowance
 * @property $id
 * @property $player_id
 * @property $allowance_id
 * @property $created_at
 * @property $updated_at
 */
class PackageAllowance extends ActiveRecord
{
  public static function tableName()
  {
    return '{{%package_allowance}}';
  }

  public function rules()
  {
    return [
      [['player_id', 'allowance_id'], 'required'],
      [['player_id', 'allowance_id'], 'integer', 'max' => 11],
      [['created_at', 'updated_at'], 'integer']
    ];
  }
}