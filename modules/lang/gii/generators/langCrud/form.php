<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
///* @var $generator \gii\generators\langCrud\Generator */
/* @var $generator modules\lang\gii\generators\langCrud\Generator */
;
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'langModelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'enablePjax')->checkbox();
echo $form->field($generator, 'messageCategory');
echo '<hr/><h3>View options:</h3>';
echo $form->field($generator, 'indexPageTitle');
echo $form->field($generator, 'singularEntityName');