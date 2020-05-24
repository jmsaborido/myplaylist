<?php

use kartik\date\DatePicker;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Consolas */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="consolas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'denom')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>