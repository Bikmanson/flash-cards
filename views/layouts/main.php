<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use modules\lang\widgets\langSwitcher\LangSwitcher;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
  <?php
  NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
      'class' => 'navbar-inverse navbar-fixed-top',
    ],
  ]);

  $guestNav = [
    ['label' => yii::t('app', 'About'), 'url' => ['/site/about']],
    ['label' => yii::t('app', 'Contact'), 'url' => ['/site/contact']],
    ['label' => yii::t('app', 'SignUp'), 'url' => ['/site/sign-up']],
    ['label' => yii::t('app', 'Login'), 'url' => ['/site/login']]
  ];

  $userNav = [
    ['label' => yii::t('app', 'Play'), 'url' => ['/play/start']],
    ['label' => yii::t('app', 'Cards'), 'url' => ['/card/index']],
    ['label' => yii::t('app', 'Packages'), 'url' => ['/package/index']],
    ['label' => yii::t('app', 'About'), 'url' => ['/site/about']],
    ['label' => yii::t('app', 'Contact'), 'url' => ['/site/contact']],
    '<li>'
    . Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
      yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
      ['class' => 'btn btn-link logout']
    )
    . Html::endForm()
    . '</li>'
  ];

  $langs = ArrayHelper::map([
    [
      'slug' => 'en',
      'name' => 'English'
    ],
    [
      'slug' => 'ru',
      'name' => 'Russian'
    ]
  ], 'slug', 'name');

  echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => Yii::$app->user->isGuest ? $guestNav : $userNav,
  ]);
  NavBar::end();
  ?>

    <div class="container">
      <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>
      <?= Alert::widget() ?>
      <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
