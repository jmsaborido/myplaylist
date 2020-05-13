<?php

use app\models\Pendientes;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Completados */

$this->title = 'Completando ' . $juego->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Completados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="completados-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row mb-3">
        <div class="col text-center">
            <?= Html::img('https://images.igdb.com/igdb/image/upload/t_cover_big/' . $juego->img_api . '.jpg') ?>
        </div>
    </div>

    <div class="completados-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'juego_id')->hiddenInput(['value' => $juego->id])->label(false) ?>

        <?= $form->field($model, 'consola_id')->dropDownList($totalC, ['value' => isset($pendiente) ? $pendiente->consola_id : 0])->label('Consola') ?>

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
                        'format' => 'yyyy/dd/m'
                    ]

                ]
            ); ?>
        <?= $form->field($model, 'pasado')->checkbox(['checked' => isset($pendiente) ? $pendiente->pasado == 1 : false]) ?>

        <?= isset($pendiente->id) ? $form->field($pendiente, 'id')->hiddenInput(['value' => $pendiente->id])->label(false) : "" ?>

        <div class="form-group">
            <?= Html::submitButton('Marcar como completado', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>