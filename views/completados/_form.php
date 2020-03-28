<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Completados */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="completados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'juego_id')->textInput() ?>

    <?= $form->field($model, 'consola_id')->dropDownList($totalC)->label('Consola') ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'pasado')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>