<?php
/**
 *
 */
namespace modules\lang\widgets\multipleDelete;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class MultipleDelete extends Widget
{
    public $deleteConfirm = 'Вы уверены, что хотите удалить выбранные записи?';
    /**
     * @var string|array
     */
    public $url = ['multiple-delete'];
    public $btnClass = 'btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air';
    public $btnText = '<span><i class="la la-trash "></i><span>Удалить</span></span>';
    public $gridId;
    /**
     * @inheritdoc
     */
    public function init()
    {
        if(empty($this->gridId))
            throw new InvalidConfigException('"gridId" should be set');
        parent::init();
    }
    /**
     * Run widget
     */
    public function run()
    {
        MultipleDeleteAsset::register($this->getView());
        return Html::button($this->btnText, [
          'class' => $this->btnClass . ' multiple-delete',
          'data-gridid' => $this->gridId,
          'data-deleteconfirm' => $this->deleteConfirm,
          'data-url' => Url::to($this->url),
        ]);
    }
}