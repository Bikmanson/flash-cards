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
use yii\helpers\Json;

class PlayController extends Controller
{
  public function actionIndex(bool $restart = false)
  {
    return $this->render('index', [
      'restart' => $restart
    ]);
  }

  public function actionNextCard($currentCardId = null) //todo: receive parameter $cardId
  {
    $allCardIds = Card::getAllCardIds();
    if ($currentCardId) {
      $nextCardId = $this->getNextElementOfArray($allCardIds, $currentCardId);
      if (!$nextCardId) {
        return $this->redirect(['index', 'restart' => true]);
      }
    } else {
      $nextCardId = $allCardIds[0];
    }
    $nextCard = Card::findOne(['id' => $nextCardId]);
    $question = $nextCard->question;
    $answer = $nextCard->answer;
    $cardInfo = [
      'question' => $question,
      'answer' => $answer,
      'currentCardId' => $nextCardId
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
  private function getNextElementOfArray(array $arr, $currentVal)
  {
    $currentIndex = array_search($currentVal, $arr);
    $nextIndex = $currentIndex + 1;

    if ($arr[$nextIndex]) {
      return $arr[$nextIndex];
    }

    return false;
  }
}