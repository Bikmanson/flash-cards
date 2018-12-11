<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator modules\lang\gii\generators\langCrud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
/* @var $langModel \yii\db\ActiveRecord */
$langModel = new $generator->langModelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
  $safeAttributes = $model->attributes();
}
$langSafeAttributes = $langModel->safeAttributes();
if (empty($langSafeAttributes)) {
  $langSafeAttributes = $langModel->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use modules\lang\widgets\langActiveForm\ActiveForm;
use backend\widgets\crudActions\CrudActions;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form backend\widgets\langActiveForm\LangActiveForm */

?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

  <?= "<?php " ?>$form = ActiveForm::begin([
  'defaultLangInd' => $model->getDefaultLangInd(),
  ]); ?>

  <div class="m-portlet__head">
    <div class="m-portlet__head-caption">
      <?php echo '<?=' ?> CrudActions::widget(["model" => $model, "template" => "{index}"]) ?>
    </div>
    <div class="m-portlet__head-tools">
      <ul class="m-portlet__nav">
        <li class="m-portlet__nav-item">
          <?= "<?=" ?> Html::dropDownList(null, $model->getDefaultLangInd(), $model->getLangMap(), [
          'class' => 'form-control',
          'id' => 'lang-dropdown',
          ]) ?>
        </li>
        <li class="m-portlet__nav-item">
          <?= '<?=' ?> CrudActions::widget(['model' => $model,]); ?>
        </li>
      </ul>
    </div>
  </div>
  <div class="m-portlet__body">
    <div class="row">
      <div class="col-xl-8 offset-xl-2">
<?php $atts = [];
        $counter = 1;
        $index = 0;
        foreach ($generator->getColumnNames() as $attribute) {
          if (in_array($attribute, $safeAttributes) && !in_array($attribute, ['created_at', 'updated_at'])) {
            $atts[$index][] = $attribute;
            if ($counter++ % 2 === 0) {
              $counter = 1;
              $index++;
            }
          }
        }
        foreach ($atts as $attGroup) : ?>
          <div class="row">
<?php foreach ($attGroup as $att) : ?>
            <div class="col-md-6">
<?php echo "              <?= " . $generator->generateActiveField($att) . " ?>" . PHP_EOL; ?>
            </div>
<?php endforeach; ?>
          </div>
<?php endforeach; ?>
<?php $atts = [];
        $counter = 1;
        $index = 0;
        foreach ($generator->getLangColumnNames() as $attribute) {
          if (in_array($attribute, $langSafeAttributes) && !in_array($attribute, ['entity_id'])) {
            $atts[$index][] = $attribute;
            if ($counter++ % 2 === 0) {
              $counter = 1;
              $index++;
            }
          }
        }
        foreach ($atts as $attGroup) : ?>
          <div class="row">
<?php foreach ($attGroup as $att) : ?>
            <div class="col-md-6">
<?php echo "              <?= " . $generator->generateLangActiveField($att) . " ?>" . PHP_EOL; ?>
            </div>
<?php endforeach; ?>
          </div>
<?php endforeach; ?>
      </div>
    </div>
    <?= "<?php " ?>ActiveForm::end(); ?>

  </div>
</div>