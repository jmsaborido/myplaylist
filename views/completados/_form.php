<?php

use kartik\date\DatePicker;
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

    <?= $form->field($model, 'fecha')
        ->widget(
            DatePicker::classname(),
            [
                'readonly' => true,
                'options' => ['placeholder' => date('d/m/Y')],
                'removeButton' => false,
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'autoclose' => true,
                    'format' => 'yyyy/m/dd'
                ]

            ]
        ); ?>
    <?= $form->field($model, 'pasado')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Completar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>