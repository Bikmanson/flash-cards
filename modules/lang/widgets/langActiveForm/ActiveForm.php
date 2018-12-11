<?php
namespace modules\lang\widgets\langActiveForm;

use backend\lib\View;
use yii\helpers\Html;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $langSelector;
    public $defaultLangInd;
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->view->on(View::EVENT_END_PAGE, [$this, 'registerLangJs']);
        parent::init();
    }

    protected function registerLangJs()
    {
        $path = \Yii::getAlias("@backend/widgets/langActiveForm/assets/langActiveForm.js");
        $url = \Yii::$app->assetManager->publish($path);
        echo Html::jsFile($url[1], [
            'data-formid' => $this->options['id'],
            'data-deflangind' => $this->defaultLangInd,
        ]);
    }

    /**
     * @param \yii\base\Model|\yii\base\Model[] $model
     * @param string $attribute
     * @param array $options
     * @return ActiveField|ActiveField
     */
    public function field($model, $attribute, $options = [])
    {
        if(is_array($model)){
            $f = parent::field($model[0], $attribute, $options);
            return new ActiveField($f, $model, $attribute);
        }
        return parent::field($model, $attribute, $options);
    }
}