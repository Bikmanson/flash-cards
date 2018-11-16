<?php

namespace app\forms;

use app\lib\Model;
use app\models\Card;
use yii\db\Exception;

/**
 * Class CardForm
 * @package app\forms
 * @property integer $id
 * @property string $question
 * @property string $answer
 */
class CardForm extends Model
{
  public $card;
  public $question;
  public $answer;
  public $cardId;

  public function __construct(Card $card = null, array $config = [])
  {
    if($card){
      $this->card = $card;

      if(!$this->autoFilling($this->card)){
        throw new Exception('The Card Form is not valid');
      }
    }

    parent::__construct($config);
  }

  public function rules()
  {
    return [
      [['question', 'answer'], 'required'],
      [['question', 'answer'], 'string', 'max' => 255],
      ['cardId', 'integer', 'max' => 11],
    ];
  }

  public function attributeLabels()
  {
    return [
      'question' => 'Question',
      'answer' => 'Answer'
    ];
  }

  private function autoFilling(Card $card)
  {
    $this->question = $card->question;
    $this->answer = $card->answer;
    $this->cardId = $card->id;

    if ($this->validate()) {
      return true;
    }

    return false;
  }
}
