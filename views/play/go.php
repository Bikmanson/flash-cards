<?php

use app\services\PackageService;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\app\assets\PlayAsset::register($this);

/**
 * @var $restart bool
 * @var $packages array
 */

$packageIds = Yii::$app->request->post('packageIds');
$csIds = $packageIds ? implode(',', $packageIds) : ''; // coma separated ids

$this->registerJs("
$(document).ready(function(){
    $('#start').on('click', function(){
        $.ajax({
              url: '" . Url::to(['next-card', 'csIds' => $csIds]) . "',
              dataType: 'html',
              success: function(response){
                $('#response').html(response);
              },
        });
    });
});

");
?>

<div class="b-start-screen">

    <div class="b-start-screen__flashes b-flashes">

      <?php $flashes = Yii::$app->session->getAllFlashes() ?>
      <?php foreach ($flashes as $flash): ?>
          <p class="b-flashes__item"><?= $flash ?></p>
      <?php endforeach; ?>

    </div>

    <div id="response" class="b-ajax-window b-start-screen__window">

      <?php if (!$restart): ?>
          <div id="start" class="b-btn b-btn_big b-start-screen__btn"><?= yii::t('app', 'Start') ?></div>
      <?php elseif ($restart): ?>
          <a href="<?= Url::to(['start']) ?>" id="restart"
             class="b-btn b-btn_big b-start-screen__btn"><?= yii::t('app', 'Restart') ?></a>
      <?php endif; ?>

    </div>

</div>
