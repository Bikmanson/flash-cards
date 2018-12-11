<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07.12.2016
 * Time: 12:45
 */

namespace modules\lang\widgets\multipleDelete;


use yii\web\AssetBundle;

class MultipleDeleteAsset extends AssetBundle
{
    public $sourcePath = '@backend/widgets/multipleDelete/assets';

    public $js = [
        'multiple-delete.js',
    ];

    public $depends = [
        'common\components\metronic\SweetAlertAsset',
    ];
}