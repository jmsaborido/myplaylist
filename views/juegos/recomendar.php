<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



$this->title = 'Recomendar ' . $juego->nombre . ' a...';
?>
<div class="group-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="conversacion-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Recomendar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>