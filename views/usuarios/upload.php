<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['action' => ['usuarios/upload', 'id' => Yii::$app->user->id]]);

echo $form->field($model, 'eventImage')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    'language' => 'es',
]);

echo Html::submitButton("Subir Imagen", ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>