<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 21.11.2018
 * Time: 15:41
 */

namespace app\services;


use app\models\Card;
use app\models\Package;
use app\models\PackagePermission;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Yii;
use yii\db\Exception;
use yii\web\BadRequestHttpException;

class CardService
{
  public static function getCards(array $packageIds = []): array
  {
    if (!empty($packageIds) && !PackageService::areAllowed($packageIds)) {
      throw new AccessDeniedException('One or more packages are not allowed for current user!');
    }
    $playerId = Yii::$app->user->identity->getId();

    if (empty($packageIds)) {
      $permissions = PackagePermission::find()->where(['player_id' => $playerId])->all();
      foreach ($permissions as $permission) {
        /** @var $permission PackagePermission */
        $packageIds[] = $permission->package_id;
      }
    }

    $cards = [];
    foreach ($packageIds as $packageId) {
      array_push($cards, Card::find()->where(['package_id' => $packageId])->all());
    }

    return $cards;
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
      /** @var $card Card */
      $ids[] = $card->id;
    }

    return $ids;
  }

  public static function defaultPacking(array $cards)
  {
    foreach ($cards as $card) {
      if (!$card->package_id) {
        $defaultPackage = PackageService::provideDefaultPackage();
        $card->package_id = $defaultPackage->id;
      }
    }
  }
}