<?php
namespace app\components\metronic;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
	public $sourcePath = '@common/components/metronic/assets';
	public $js = [
		'snippets/custom/pages/user/login.js'
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}