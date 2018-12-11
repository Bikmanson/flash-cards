<?php
namespace modules\lang\lib;

use modules\lang\common\models\Lang;
use yii\db\BaseActiveRecord;

class VariationBehavior extends \yii2tech\ar\variation\VariationBehavior
{
    /**
     * Returns default variation model, matching [[defaultVariationRelation]] relation
     * @param bool $autoCreate whether to automatically create model - if it does not exist.
     * @return BaseActiveRecord|null default variation model, `null` - if not found.
     */
    public function getDefaultVariationModel($autoCreate = false)
    {
        if ($this->getIsVariationModelsInitialized()) {
            $model = $this->getVariationModel($this->getDefaultVariationOptionReference());
        } else {
            $model = parent::getDefaultVariationModel($autoCreate);
            if ($model === null) {
                $model = $this->getVariationModel(Lang::getDefaultLang()->id);
                $this->setVariationModels(null);
            }
        }
        return $model;
    }

    /**
     * Handles owner 'afterValidate' event, ensuring variation models are validated as well
     * in case they have been fetched.
     * @param \yii\base\Event $event event instance.
     */
    public function afterValidate($event)
    {
        if ($this->getIsVariationModelsInitialized()) {
            $variationModels = $this->getVariationModels();
        } elseif ($this->defaultVariationRelation !== null && $this->owner->isRelationPopulated($this->defaultVariationRelation)) {
            $defaultVariationModel = $this->owner->{$this->defaultVariationRelation};
            if (!is_object($defaultVariationModel)) {
                return;
            }
            $variationModels = [$defaultVariationModel];
        } else {
            return;
        }

        foreach ($variationModels as $variationModel) {
            if ($this->variationSaveFilter === null || call_user_func($this->variationSaveFilter, $variationModel)) {
                if (!$variationModel->validate()) {
                    $this->owner->addErrors($variationModel->getErrors());
                }
            }
        }
    }
}