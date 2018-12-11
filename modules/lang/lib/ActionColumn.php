<?php
namespace modules\lang\lib;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
	public $template = '{update} {delete}';

	protected function initDefaultButtons() {
		$this->initDefaultButton('view', 'la la-eye');
		$this->initDefaultButton('update', 'la la-edit');
		$this->initDefaultButton('delete', 'la la-trash-o', [
			'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
			'data-method' => 'post',
		]);
	}

	protected function initDefaultButton( $name, $iconName, $additionalOptions = [] ) {
		if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
			$this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
				switch ($name) {
					case 'view':
						$title = Yii::t('yii', 'View');
						break;
					case 'update':
						$title = Yii::t('yii', 'Update');
						break;
					case 'delete':
						$title = Yii::t('yii', 'Delete');
						break;
					default:
						$title = ucfirst($name);
				}
				$options = array_merge([
					'title' => $title,
					'aria-label' => $title,
					'data-pjax' => '0',
					'class' => 'm-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill',
				], $additionalOptions, $this->buttonOptions);
				$icon = Html::tag('i', '', ['class' => "$iconName"]);
				return Html::a($icon, $url, $options);
			};
		}
	}
}