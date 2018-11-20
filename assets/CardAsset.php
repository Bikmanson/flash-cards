<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 20.11.2018
 * Time: 16:19
 */

namespace app\assets;


use app\lib\AssetBundle;

class CardAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';

  public $css = [
    'css/card.css'
  ];
  public $js = [
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
  ];
}