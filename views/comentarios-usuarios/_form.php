<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComentariosCompletados */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="comentarios-completados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cuerpo')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Modificar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>