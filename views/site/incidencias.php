<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Incidencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('Incidencia Enviada')) : ?>

        <div class="alert alert-success">
            Gracias por enviar esa incidencia, lo arreglaremos lo más rapido posbloe.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport) : ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else : ?>

        <p>
            Si ha encontrado un problema, rellene el siguiente formulario y lo arreglaremos lo más rapido posible
        </p>

        <div class="row">
            <div class="col-xl-8">

                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'horizontalCssClasses' => ['label' => 'col-sm-2'],
                    ],
                ]); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'imageOptions' => ['class' => 'col-sm-3', 'style' => 'padding: 0'],
                    'options' => ['class' => 'form-control col-sm-7', 'style' => 'display: inline'],
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>