<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 09.11.2018
 * Time: 15:20
 */

namespace app\assets;


use app\lib\AssetBundle;

class BowerAsset extends AssetBundle
{
  public $sourcePath = '@bower/animate.css';

  public $css = [
    'animate.css',
  ];
}