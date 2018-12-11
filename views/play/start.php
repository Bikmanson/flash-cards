<?php

use app\assets\PlayAsset;
use app\services\PackageService;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

PlayAsset::register($this);

  /**
   * @var $form ActiveForm
   */

$packages = PackageService::getMap();

$this->registerJs("
    $(document).ready(function(){
        $('#packageIdSelector').multiSelect();
    });
");
?>

<form action="<?= Url::to('go') ?>" method="post">

    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

    <label for="packageIdSelector"><?= yii::t('app', 'Select the packages') ?></label>
    <select multiple name="packageIds[]" id="packageIdSelector">
      <?php foreach ($packages as $id => $packageName): ?>

          <option value="<?= $id ?>"><?= $packageName ?></option>

      <?php endforeach; ?>
    </select>

    <input type="submit" value="<?= yii::t('app', 'Go') ?>">
    <i><?= yii::t('app', 'If no packages will be selected, by default all are included') ?>.</i>

</form>
