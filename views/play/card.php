<?php

use yii\helpers\Url;

\app\assets\PlayAsset::register($this); //todo: transfer this to layout

/**
 * @var $cardInfo array|bool
 */

$this->registerJs("

    function getAnswer()
    {
        $('#question').addClass('b-card__side_hide');
        $('#answer').addClass('b-card__side_show');
    }
    
    function nextQuestion()
    {
        $(this).removeClass('b-card__side_show').addClass('b-card__side_next');
        
        $.ajax({
              url: '" . Url::to(['next-card', 'csIds' => $cardInfo['packageIds'], 'currentCardId' => $cardInfo['currentCardId']]) . "',
              dataType: 'html',
              success: function(response){
                $('#response').html(response);
              },
        });
    }

    $('#question').on('click', function(){
        getAnswer();
     });

    $('#answer').on('click', function(){
        nextQuestion();
    });
");

?>

<div class="b-card">
    <div id="question" class="b-card__side b-card__side_question animated bounceInRight">
        <div class="b-card__side__title"><?= yii::t('app', 'Question') ?></div>
        <div class="b-card__side__text">
          <?= $cardInfo['question'] ?>
        </div>
    </div>
    <div id="answer" class="b-card__side b-card__side_answer">
        <div class="b-card__side__title"><?= yii::t('app', 'Answer') ?></div>
        <div class="b-card__side__text">
          <?= $cardInfo['answer'] ?>
        </div>
    </div>
</div>