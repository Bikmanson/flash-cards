<?php

namespace app\models;

use Yii;
use modules\lang\common\models\Lang;

/**
* This is the model class for table "{{%flash_lang}}".
*
* @property integer $id
* @property integer $entity_id
* @property integer $lang_id
* @property string $question
* @property string $answer
*
* @property Flash $entity
* @property Lang $lang
*/
class FlashLang extends \modules\lang\lib\LangActiveRecord
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%flash_lang}}';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['entity_id', 'lang_id'], 'integer'],
            [['question', 'answer'], 'string'],
            [['entity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flash::class, 'targetAttribute' => ['entity_id' => 'id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::class, 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
            'lang_id' => 'Lang ID',
            'question' => 'Question',
            'answer' => 'Answer',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEntity()
    {
        return $this->hasOne(Flash::class, ['id' => 'entity_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLang()
    {
        return $this->hasOne(Lang::class, ['id' => 'lang_id']);
    }
}
