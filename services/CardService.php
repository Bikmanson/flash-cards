<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 21.11.2018
 * Time: 15:41
 */

namespace app\services;


use app\models\Card;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Yii;

class CardService
{
  public static function getCards(array $packageIds = []): array
  {
    if (!empty($packageIds) && !PackageService::areAllowed($packageIds)) {
      throw new AccessDeniedException('One or more packages are not allowed for current user!');
    }
    $playerId = Yii::$app->user->identity->getId();

    if (empty($packageIds)) {
      $a = Card::find()->where(['player_id' => $playerId])->all();
      return $a;
    }

    $cards = [];
    foreach ($packageIds as $packageId) {
      $cards[] = Card::findOne(['package_id' => $packageId, 'player_id' => $playerId]);
    }

    return $cards;
  }
}