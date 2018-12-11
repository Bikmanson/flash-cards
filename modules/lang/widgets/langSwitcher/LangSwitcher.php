<?php
namespace modules\lang\widgets\langSwitcher;

use Codeception\Exception\ConfigurationException;
use modules\lang\lib\TranslatableActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class LangSwitcher extends \yii\widgets\ActiveForm
{
    public $model = null;
    public $options = [];
    public $id = 'lang-dropdown';

    public function init()
    {
        if( strlen($this->id) <= 0 ) {
            throw new ConfigurationException('id must be defined');
        }
        if( $this->model === null ) {
            throw new ConfigurationException('model must be defined');
        }
        if( !($this->model instanceof TranslatableActiveRecord) ) {
            throw new ConfigurationException('model must be instance of TranslatableActiveRecord');
        }
        parent::init();
    }

    public function run()
    {
        echo Html::dropDownList(null, $this->getDefaultLangInd(), $this->model->getLangMap(), ArrayHelper::merge($this->options, [
            'class' => 'form-control',
            'id' => $this->id,
        ]));
        parent::run();
    }
}