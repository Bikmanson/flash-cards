<?php
namespace app\components\metronic;

use yii\web\AssetBundle;

class DatatableAsset extends AssetBundle
{
	public $sourcePath = '@common/components/metronic/assets';
	public $js = [
		'vendors/custom/datatables/datatables.bundle.js',
		'demo/default/custom/crud/datatables/basic/basic.js'
	];
	public $css = [
		'vendors/custom/datatables/datatables.bundle.css'
	];
	public $depends = [
		'yii\bootstrap\BootstrapPluginAsset',
		'yii\web\JqueryAsset',
	];
}