<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $generator modules\lang\gii\generators\langCrud\Generator */
$urlParams = $generator->generateUrlParams();
echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= strtr($generator->generateString('Редактировать ' .
  ($generator->singularEntityName ? : Inflector::camel2words(StringHelper::basename($generator->modelClass))) .
  ': {nameAttribute}', ['nameAttribute' => '{nameAttribute}']), [
  '{nameAttribute}\'' => '\' . $model->' . $generator->getNameAttribute()
]) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->indexPageTitle ? "'$generator->indexPageTitle'" : $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Редактировать') ?>;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">

    <?= '<?= ' ?>$this->render('_form', [
    'model' => $model,
    ]) ?>

</div>