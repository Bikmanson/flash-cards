<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
echo "<?php\n";
?>

use yii\helpers\Url;
use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->indexPageTitle ? "'$generator->indexPageTitle'" : $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m-portlet__head">
  <div class="m-portlet__head-caption">
    <?= '<?=' ?> \backend\widgets\multipleDelete\MultipleDelete::widget([
      'gridId' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
    ]) ?>
  </div>
  <div class="m-portlet__head-tools">
    <ul class="m-portlet__nav">
      <li class="m-portlet__nav-item">
        <a href="<?= '<?= ' ?>Url::to(['create']) ?>"
           class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span>Создать</span>
						</span>
        </a>
      </li>
    </ul>
  </div>
</div>
<div class="m-portlet__body">
  <div class="dataTables_wrapper">
    <div class="row">
      <div class="col-sm-12">
        <?= $generator->enablePjax ? "    <?php Pjax::begin(); ?>\n" : '' ?>
        <?php if ($generator->indexWidgetType === 'grid'): ?>
          <?= "<?= " ?>GridView::widget([
          'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
          'options' => ['class' => 'dataTable'],
          'dataProvider' => $dataProvider,
          <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
          ['class' => \backend\lib\CheckboxColumn::class],
          <?php
          $count = 0;
          if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
              if (++$count < 6) {
                echo "            '" . $name . "',\n";
              } else {
                echo "            //'" . $name . "',\n";
              }
            }
          } else {
            foreach ($tableSchema->columns as $column) {
              $format = $generator->generateColumnFormat($column);
              if (++$count < 6) {
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
              } else {
                echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
              }
            }
          }
          ?>
          ['class' => \backend\lib\ActionColumn::class],
          ],
          ]); ?>
        <?php else: ?>
          <?= "<?= " ?>ListView::widget([
          'dataProvider' => $dataProvider,
          'itemOptions' => ['class' => 'item'],
          'itemView' => function ($model, $key, $index, $widget) {
          return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
          },
          ]) ?>
        <?php endif; ?>
        <?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>
      </div>
    </div>
  </div>
</div>
