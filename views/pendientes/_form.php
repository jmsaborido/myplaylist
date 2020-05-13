<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pendientes */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="pendientes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <?= $form->field($model, 'juego_id')->textInput() ?>

    <?= $form->field($model, 'consola_id')->textInput() ?>

    <?= $form->field($model, 'pasado')->checkbox() ?>

    <?= $form->field($model, 'tengo')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
