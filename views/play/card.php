<?php

use yii\helpers\Url;

\app\assets\PlayAsset::register($this); //todo: transfer this to layout

/**
 * @var $cardInfo array
 */

/** todo:
 * parse json formatted array with question, answer and currentCardId
 * set question and answer to needed places
 */

$this->registerJs("

    function getAnswer()
    {
        $('#question').addClass('b-card_hide');
        $('#answer').addClass('b-card_show');
    }
    
    function nextQuestion()
    {
        $(this).removeClass('b-card_show').addClass('b-card_next');
        
        $.ajax({
              url: '" . Url::to(['next-card', 'currentCardId' => $cardInfo['currentCardId']]) . "',
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

<div id="question" class="b-card b-card_question-side animated bounceInRight">
    <div class="b-card__title">Question</div>
    <div class="b-card__text">
        <?= $cardInfo['question'] ?>
    </div>
</div>
<div id="answer" class="b-card b-card_answer-side">
    <div class="b-card__title">Answer</div>
    <div class="b-card__text">
      <?= $cardInfo['answer'] ?>
    </div>
</div>
