<?php
namespace app\components\metronic;

use yii\web\AssetBundle;
use yii\web\View;

class CoreAsset extends AssetBundle
{
	public $sourcePath = '@common/components/metronic/assets';
	public $js = [
		'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js',
		'vendors/base/vendors.bundle.js',
		'demo/default/base/scripts.bundle.js',
	];
	public $css = [
		'vendors/base/vendors.bundle.css',
		'demo/default/base/style.bundle.css'
	];
	public $depends = [
		'yii\bootstrap\BootstrapPluginAsset',
		'yii\web\JqueryAsset',
	];
	public $jsOptions = [
		'position' => View::POS_END
	];
}