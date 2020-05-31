<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Estadisticas a mostrar';
?>
<main class="usuarios-seleccion">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
        ],
    ]); ?>

    <?= $form->field($model, 'debut')->checkbox(['autofocus' => true])
        ->label("Datos relacionado con la fecha de debut de los juegos") ?>
    <?= $form->field($model, 'anterior')->checkbox()
        ->label("Datos relacionado con los juegos completados anteriormente") ?>
    <?= $form->field($model, 'fechas')->checkbox()
        ->label("Datos relacionado con las fechas de finalizacion de juegos") ?>


    <div class="form-group">
        <div class="offset-sm-2">
            <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary', 'name' => 'seleccion-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</main>