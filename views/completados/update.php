<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Completados */

$this->title = 'Update Completados: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Completados', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="completados-update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'consola_id')->dropDownList($totalC)->label('Consola') ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'pasado')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>