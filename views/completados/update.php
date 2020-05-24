<?php

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Completados */

$this->title = 'Modificando: ' . $model->juego->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Completados', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="completados-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row mb-3">
        <div class="col text-center">
            <?= Html::img('https://images.igdb.com/igdb/image/upload/t_cover_big/' . $model->juego->img_api . '.jpg') ?>
        </div>
    </div>
    <?php $form = ActiveForm::begin(); ?>

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
        <?= Html::submitButton('Modificar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>