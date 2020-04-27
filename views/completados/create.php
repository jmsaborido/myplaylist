<?php

use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Completados */

$this->title = 'Create Completados';
$this->params['breadcrumbs'][] = ['label' => 'Completados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="completados-create">

    <h1><?= Html::encode($this->title) ?></h1>

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
                        'format' => 'dd/m/yyyy'
                    ]

                ]
            ); ?>
        <?= $form->field($model, 'pasado')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>