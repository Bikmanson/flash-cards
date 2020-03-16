<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07.12.2016
 * Time: 12:45
 */

namespace backend\widgets\crudActions;


use app\components\metronic\SweetAlertAsset;
use yii\web\AssetBundle;

class CrudActionsAsset extends AssetBundle
{
    public $sourcePath = '@modules/lang/widgets/crudActions/assets';

    public $js = [
        'link-sweetalert.js',
    ];

    public $depends = [
        SweetAlertAsset::class,
    ];
}
