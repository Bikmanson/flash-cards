<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 21.11.2018
 * Time: 14:35
 */

namespace app\services;


use app\models\Package;
use app\models\PackagePermission;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;

class PackageService
{
  public static function getMap(): array //todo: return by $id, $from, $to
  {
    $playerId = Yii::$app->user->identity->getId();

    $packagePermissions = PackagePermission::find()->where(['player_id' => $playerId])->all();
    $packages = [];
    foreach ($packagePermissions as $packagePermission) {
      /** @var $packagePermission PackagePermission */
      $packages[] = Package::findOne(['id' => $packagePermission->package_id]);
    }

    return ArrayHelper::map($packages, 'id', 'name');
  }

  public static function areAllowed(array $packageIds): bool
  {
    $playerId = Yii::$app->user->identity->getId();

    foreach ($packageIds as $packageId) {
      $permission = PackagePermission::findOne(['player_id' => $playerId, 'package_id' => $packageId]);
      if (!$permission) {
        return false;
      }
    }

    return true;
  }

  public static function permit(int $playerId, int $packageId): bool
  {
    $packagePermission = new PackagePermission();
    $packagePermission->player_id = $playerId;
    $packagePermission->package_id = $packageId;

    if ($packagePermission->save()) {
      return true;
    }

    return false;
  }

  public static function provideDefaultPackage(): Package
  {
    if (!$defaultPackage = Package::findOne([
      'creator_id' => Yii::$app->user->getId(),
      'name' => Package::DEFAULT_PACKAGE_NAME
    ])) {
      $defaultPackage = new Package(['name' => Package::DEFAULT_PACKAGE_NAME]);
      $defaultPackage->afterNewInstance();
      if (!$defaultPackage->save()) throw new Exception('Default package has not been created.');
    }

    return $defaultPackage;
  }
}