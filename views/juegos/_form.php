<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Juegos */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="juegos-form">

    <?php $form = ActiveForm::begin([
        'id' => 'juegos-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consola_id')->dropDownList($totalC)->label('Consola') ?>

    <?= $form->field($model, 'pasado')->checkbox() ?>

    <?= $form->field($model, 'genero_id')->dropDownList($totalG)->label('Genero') ?>

    <?= $form->field($model, 'year_debut')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>