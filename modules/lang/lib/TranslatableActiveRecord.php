<?php
namespace modules\lang\lib;

use app\lib\ActiveRecord;
use modules\lang\common\models\Lang;
use Yii;
use yii\db\BaseActiveRecord;

/**
 * Class SmTranslatableActiveRecord
 * @package common\lib
 *
 * @property BaseActiveRecord[] $variationModels list of all possible variation models.
 * @property BaseActiveRecord[] $defaultTranslation list of all possible variation models.
 *
 * @method \yii\db\ActiveQueryInterface hasDefaultVariationRelation
 */
abstract class TranslatableActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['translations'] = [
            'class' => VariationBehavior::className(),
            'variationsRelation' => 'translations',
            'defaultVariationRelation' => 'defaultTranslation',
            'variationOptionReferenceAttribute' => 'lang_id',
            'optionModelClass' => Lang::className(),
            'optionQueryFilter' => function($query) {
                if($query->hasProperty('isCacheLangs'))
                    $query->isCacheLangs = true;
            },
            'defaultVariationOptionReference' => Lang::getCurrent()->id,
            'variationSaveFilter' => function ($model) {
                if ($model instanceof LangActiveRecord && $model->isEmpty()) {
                    if ($model->lang_id !== Lang::getDefaultLang()->id)
                        return false;
                }
                return true;
            },
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public static function langTableName()
    {
        return preg_replace('/(\W*)(\w+)(\W*)/i', '$1$2_lang$3', static::tableName());
    }

    /**
     * Language map of model
     * @return array
     */
    public function getLangMap()
    {
        $map = [];
        foreach ($this->variationModels as $index => $variationModel) {
            $map[$index] = $variationModel->lang->name;
        }
        return $map;
    }

    /**
     * @return int|string
     */
    public function getDefaultLangInd()
    {
        $defaultLangId = Lang::getDefaultLang()->id;
        foreach ($this->variationModels as $index => $variationModel) {
            if ($variationModel->lang->id === $defaultLangId)
                return $index;
        }
        return 0;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultTranslation()
    {
        return $this->hasDefaultVariationRelation(); // convert "has many translations" into "has one defaultTranslation"
    }

    /**
     * Select only posts, that have translation on current language
     * @return \yii\db\ActiveQuery
     */
    public static function findWithCurrentLangTranslation()
    {
        $find = parent::find();

        $langTableName = static::langTableName();

        if( ! $langTableName ) {
            $tableName = static::tableName();
            if( strpos($tableName, '%') !== false ) {
                $tableName = str_replace(['{{', '%', '}}'], '', $tableName);
                $langTableName = '{{%' . $tableName . '_lang}}';
            } else {
                $langTableName = $tableName . '_lang';
            }
        }

        $langTableSchema = Yii::$app->db->schema->getTableSchema($langTableName);
        if( $langTableSchema === null ) {
            return $find;
        }

        $fkColumnName = strtolower(substr(strrchr(self::className(), "\\"), 1)) . '_id';
        $langTable = Yii::$app->db->schema->getTableSchema($langTableName);
        if( !isset($langTable->columns[$fkColumnName]) ) {
            return $find;
        }

        $find
            ->innerJoin($langTableName, static::tableName().'.id = '.$langTableName.'.'.$fkColumnName)
            ->where(['lang_id' => Lang::findOne(['locale' => Yii::$app->language])->id]);

        return $find;
    }

    /**
     * @return array
     */
    public function getTranslatedLangs()
    {
        $langs = [];
        foreach ($this->getTranslations()->all() as $translation) {
            $langs[] = Lang::findOne($translation->lang_id);
        }
        return $langs;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    abstract public function getTranslations();
}