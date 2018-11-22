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
  public $sourcePath = '@bower';

  public $css = [
    'animate.css/animate.css',
    'multiselect\css\multi-select.css'
  ];

  public $js = [
    'multiselect\js\jquery.multi-select.js'
  ];
}