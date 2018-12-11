<?php

namespace modules\lang\common\models;

/**
 * This is the ActiveQuery class for [[Lang]].
 *
 * @see Lang
 */
class LangQuery extends \yii\db\ActiveQuery
{
    public $isCacheLangs = false;

    protected static $_cashedLangs;
    /**
     * @inheritdoc
     * @return Lang[]|array
     */
    public function all($db = null)
    {
        if($this->isCacheLangs === true){
            if(isset(self::$_cashedLangs))
                return self::$_cashedLangs;
            return self::$_cashedLangs = parent::all($db);
        }
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Lang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}