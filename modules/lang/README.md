**ONLY FOR ADVANCED APP**

Add module
'lang' => [
  'class' => modules\lang\Module::class,
],

Migration
copy migrations from lang\migrations to console\migrations and do yii migrate
or
yii migrate --migrationPath=@modules/lang/migrations

composer require add string
    "yii2tech/ar-variation": "^1.0"

add @common/components/metronic

add to config local, in gii config array
    'generators' => [
          'langCrud' => [
            'class' => '\modules\lang\gii\generators\langCrud\Generator',
            'templates' => [
              'default' => '@modules/lang/gii/generators/langCrud/default',
            ]
          ],
          'langModel' => [
            'class' => '\modules\lang\gii\generators\langModel\Generator',
            'templates' => [
              'default' => '@modules/lang/gii/generators/langModel/default',
            ]
          ],
        ]

check all namespaces

create migration for creating model and model_lang tables

generate lang models by gii

generate lang crud by gii

check models

in view don't work
    multipleDelete
    langSwitcher