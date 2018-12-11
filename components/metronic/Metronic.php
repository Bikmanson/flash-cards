<?php
namespace app\components\metronic;

use Yii;
use yii\base\Component;
use yii\web\AssetBundle;
use yii\web\View;

class Metronic extends Component
{
	/**
	 * @var AssetBundle
	 */
	public static $assetsBundle;

	/**
	 * @var string Component name used in the application
	 */
	public static $componentName = 'metronic';

	public function init() {}

	/**
	 * @return Metronic Get Metronic component
	 */
	public static function getComponent() {
		return Yii::$app->{static::$componentName};
	}

	/**
	 * Get base url to metronic assets
	 * @param $view View
	 * @return string
	 */
	public static function getAssetsUrl($view)
	{
		if(static::$assetsBundle === null){
			static::$assetsBundle = static::registerThemeAsset($view);
		}
		return (static::$assetsBundle instanceof AssetBundle) ? static::$assetsBundle->baseUrl : '';
	}

	/**
	 * Register Theme Asset
	 * @param $view View
	 * @return AssetBundle
	 */
	public static function registerThemeAsset($view)
	{
		/** @var AssetBundle $themeAsset */
		static::$assetsBundle = CoreAsset::register($view);
		return static::$assetsBundle;
	}
}