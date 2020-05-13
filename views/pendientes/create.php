<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pendientes */

$this->title = 'Poniendo como pendiente ' . $juego->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Pendientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="pendientes-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row mb-3">
        <div class="col text-center">
            <?= Html::img('https://images.igdb.com/igdb/image/upload/t_cover_big/' . $juego->img_api . '.jpg') ?>
        </div>
    </div>

    <div class="pendientes-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'juego_id')->hiddenInput(['value' => $juego->id])->label(false) ?>

        <?= $form->field($model, 'consola_id')->dropDownList($totalC)->label('Consola') ?>

        <?= $form->field($model, 'pasado')->checkbox() ?>

        <?= $form->field($model, 'tengo')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Marcar como pendiente', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>