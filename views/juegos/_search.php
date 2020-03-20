<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JuegosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="juegos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'dia') ?>

    <?= $form->field($model, 'mes') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'nombre') ?>

    <?php // echo $form->field($model, 'consola') ?>

    <?php // echo $form->field($model, 'pasado')->checkbox() ?>

    <?php // echo $form->field($model, 'genero') ?>

    <?php // echo $form->field($model, 'year_debut') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
