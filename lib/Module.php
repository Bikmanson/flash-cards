<?php
namespace app\lib;

use ReflectionClass;

class Module extends \yii\base\Module
{
    const TRANSLATION_CATEGORY = 'modules';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $childClassInfo = new ReflectionClass($this);
        $dirPath = dirname($childClassInfo->getFileName());
        $dirName = basename($dirPath);
        if (\Yii::$app->id === 'app-backend') {
            $this->viewPath = $dirPath . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'views';
            $this->controllerNamespace = 'modules\\' . $dirName . '\\backend\\controllers';
        }
        if (\Yii::$app->id === 'app-frontend') {
            $this->viewPath = $dirPath . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'views';
            $this->controllerNamespace = 'modules\\' . $dirName . '\\frontend\\controllers';
        }
        parent::init();
    }

}