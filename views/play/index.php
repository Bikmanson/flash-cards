<?php

use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\PlayAsset::register($this);

/**
 * @var $restart bool
 */

$this->registerJs("
$(document).ready(function(){
    $('#start').on('click', function(){
        $.ajax({
              url: '" . Url::to(['next-card']) . "',
              dataType: 'html',
              success: function(response){
                $('#response').html(response);
              },
        });
    });
});

"); //todo: change url during actions
?>

<div class="b-start-screen">

    <div id="response" class="b-ajax-window b-start-screen__window">

      <?php if (!$restart): ?>
          <div id="start" class="b-btn b-btn_big b-start-screen__btn">Start</div>
      <?php elseif($restart): ?>
          <div id="start" class="b-btn b-btn_big b-start-screen__btn">Restart</div>
      <?php endif; ?>

    </div>

</div>
