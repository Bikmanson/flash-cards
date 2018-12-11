<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 27.10.2018
 * Time: 1:33
 */

namespace app\controllers;


use app\lib\Controller;
use app\models\Card;
use app\services\CardService;
use Yii;
use yii\helpers\Json;

class PlayController extends Controller
{
  public function actionStart()
  {
    return $this->render('start');
  }

  public function actionGo(bool $restart = false, bool $noCards = false)
  {
    if ($noCards) {
      Yii::$app->session->setFlash('no card', 'You have not cards');
    }
    return $this->render('go', [
      'restart' => $restart
    ]);
  }

  function actionNextCard(string $csIds = '', $currentCardId = null)
  {
    $packageIds = [];
    if ($csIds !== '') {
      $packageIds = array_map('intval', explode(',', $csIds)); // explode coma separated ids
    }
    $allCardIds = CardService::getAllCardIds($packageIds);

    if (!$allCardIds) return $this->redirect(['go', 'restart' => false, 'noCards' => true]);

    if ($currentCardId) {
      $nextCardId = $this->getNextElementOfArray($allCardIds, $currentCardId);
    } else {
      $nextCardId = $allCardIds[0];
    }

    if (!$nextCard = Card::findOne(['id' => $nextCardId])) {
      return $this->redirect(['go', 'restart' => true]);
    }

    $question = $nextCard->question;
    $answer = $nextCard->answer;
    $cardInfo = [
      'question' => $question,
      'answer' => $answer,
      'currentCardId' => $nextCardId,
      'packageIds' => implode(',', $packageIds),
    ];

    return $this->renderAjax('card', [
      'cardInfo' => $cardInfo
    ]);
  }

  /**
   * @param array $arr
   * @param $currentVal
   * @return mixed
   */
  private
  function getNextElementOfArray(array $arr, $currentVal)
  {
    $currentIndex = array_search($currentVal, $arr);
    $nextIndex = $currentIndex + 1;

    if ($arr[$nextIndex]) {
      return $arr[$nextIndex];
    }

    return false;
  }
}