<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%flash}}".
 *
 * @property integer $id
 *
 * @property FlashLang[] $translations
 */
class Flash extends \modules\lang\lib\TranslatableActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%flash}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTranslations()
    {
        return $this->hasMany(FlashLang::class, ['entity_id' => 'id']);
    }
}
