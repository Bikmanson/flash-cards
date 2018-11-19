<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 19.11.2018
 * Time: 15:41
 */

namespace app\forms;


use app\lib\Model;
use app\models\Player;

class SignUpForm extends Model
{
  public $username;
  public $password;
  public $passwordRepeat;

  public function rules()
  {
    /*
     * it could be set as a rule for a password
     * ['password', 'pattern' => '/^(?=.*[0-9])(?=.*[A-Z])([a-zA-Z0-9]+)$/']
     * it will require at least one upper-case letter and at least one digit (lower-case letters are not necessary)
     * PS this is from StackOverflow
     */
    return [
      [['username', 'password', 'passwordRepeat'], 'required'],
      ['username', 'string', 'max' => 20],
      ['password', 'string', 'max' => 255],
      ['passwordRepeat', 'passwordRepeatValidate']
    ];
  }

  public function passwordRepeatValidate($passwordRepeat) //may be the second parameter $params is required
  {
    return $passwordRepeat === $this->password;
  }
}