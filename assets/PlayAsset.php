<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 27.10.2018
 * Time: 1:46
 */

namespace app\assets;


use app\lib\AssetBundle;
use app\assets\BowerAsset;

class PlayAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';

  public $css = [
    'css/play.css'
  ];
  public $js = [
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
    BowerAsset::class
  ];
}