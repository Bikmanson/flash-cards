<?php
namespace modules\lang\lib;

use app\lib\ActiveRecord;
use modules\lang\common\models\Lang;
use yii\helpers\StringHelper;

/**
 * Class SmLangActiveRecord
 * @package common\lib
 */
class LangActiveRecord extends ActiveRecord
{
    public function init(){
        parent::init();
        $name = str_replace("lang", "id", strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", StringHelper::basename(self::className()))));
        if($this->hasAttribute($name))
            $this->notEmptyAttributes[] = $name;
    }
    /**
     * Check whether the model is empty
     * @return bool
     */
    public function isEmpty(){
        if(isset($this->_isEmpty) && is_bool($this->_isEmpty))
            return $this->_isEmpty;
        foreach ($this->attributes as $key=>$value) {
            if(!in_array($key, $this->notEmptyAttributes) && !empty($value))
                return $this->_isEmpty = false;
        }
        return $this->_isEmpty = true;
    }

    /**
     * @var array Attributes that can be not empty
     */
    protected $notEmptyAttributes = ['id', 'lang_id', 'entity_id'];
    /**
     * @var boolean
     */
    protected $_isEmpty;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }
}