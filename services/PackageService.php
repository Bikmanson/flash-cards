<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 21.11.2018
 * Time: 14:35
 */

namespace app\services;


use app\models\Package;
use app\models\PackageAllowance;
use Yii;
use yii\helpers\ArrayHelper;

class PackageService
{
  public static function getMap(): array //todo: return by $id, $from, $to
  {
    return ArrayHelper::map(Package::find()->all(), 'id', 'name');
  }

  public static function areAllowed(array $packageIds): bool
  {
    $playerId = Yii::$app->user->identity->getId();

    foreach ($packageIds as $packageId) {
      $allowance_id = Package::findOne(['id' => $packageId])->allowance_id;
      $allowance = PackageAllowance::findOne(['player_id' => $playerId, 'allowance_id' => $allowance_id]);
      if (!$allowance) {
        return false;
      }
    }

    return true;
  }
}