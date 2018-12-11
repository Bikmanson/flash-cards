<?php
namespace modules\lang\widgets\langActiveForm;

use yii\base\BaseObject;
use yii\base\ErrorHandler;

class ActiveField extends BaseObject
{
    protected $models;
    protected $attr;
    /**
     * @var ActiveField
     */
    protected $instance;
    protected $calls = [];
    public function __construct($instance, $models, $attr)
    {
        $this->instance = $instance;
        $this->models = $models;
        $this->attr = $attr;
    }
    public function __call($method, $params)
    {
        //$this->instance->$method(...$params);
        $this->calls[] = [$method, $params];
        return $this;
    }
    public function __toString()
    {
        // __toString cannot throw exception
        // use trigger_error to bypass this limitation
        try {
            $results = [];
            foreach ($this->models as $index => $model) {
                $this->instance->options['data-langind'] = $index; //set the lang index of the field
                $this->instance->model = $model;
                $pattern = '/([\[\d{1,}\]]{0,})(.+$)/i';
                $replacement = '$1' . "[$index]" . '$2';
                $this->instance->attribute = preg_replace($pattern, $replacement, $this->attr);
                $this->instance->parts = [];
                foreach ($this->calls as $call) {
                    $this->instance->{$call[0]}(...$call[1]);
                }
                $results[] = $this->instance->render();
            }
            return implode($results);
        } catch (\Exception $e) {
            ErrorHandler::convertExceptionToError($e);
            return '';
        }
    }
}