<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
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
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/img/logo.png', ['class' => 'navbar-logo', 'alt' => 'logo', 'width' => '125px']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-dark bg-dark navbar-expand-md fixed-top',
            ],
            'collapseOptions' => [
                'class' => 'justify-content-end',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'Juegos', 'url' => ['/juegos/index']],
                ['label' => 'Completados', 'url' => ['/completados/index']],
                [
                    'label' => Yii::$app->user->isGuest ? 'Usuarios' : Yii::$app->user->identity->nombre,
                    'items' =>
                    Yii::$app->user->isGuest ? [
                        ['label' => 'Login', 'url' => ['/site/login']],
                        ['label' => 'Registrarse', 'url' => ['usuarios/registrar']],
                    ] : [
                        ['label' => 'Modificar', 'url' => ['usuarios/update']],
                        (Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Logout',
                                ['class' => 'dropdown-item'],
                            )
                            . Html::endForm()),
                    ],
                    'options' => ['class' => 'navbar-nav'],
                ],
            ],
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
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>