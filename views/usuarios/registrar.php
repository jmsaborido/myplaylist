<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\password\PasswordInput;

$this->title = 'Registrar usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Introduzca los siguientes datos para registrarse:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
        ],
    ]); ?>
    <?php Yii::debug(Yii::$app->getErrorHandler()) ?>

    <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'nombre')->textInput() ?>
    <?= $form->field($model, 'apellidos')->textInput() ?>
    <?= $form->field($model, 'password')->widget(PasswordInput::classname(), [
        'size' => 'lg',
        'togglePlacement' => 'rigth',
        'pluginOptions' => [
            'verdictTitles' => [
                0 => 'No definida',
                1 => 'Muy debil',
                2 => 'Debil',
                3 => 'Buena',
                4 => 'Muy buena',
                5 => 'Excelente'
            ],
            'verdictClasses' => [
                0 => 'text-muted',
                1 => 'text-danger',
                2 => 'text-warning',
                3 => 'text-info',
                4 => 'text-primary',
                5 => 'text-success'
            ],
        ]
    ]) ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <div class="form-group">
        <div class="offset-sm-2">
            <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>