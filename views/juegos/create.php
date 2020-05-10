<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Group */


$this->title = 'Buscar Juegos';
?>
<div class="group-create">
    <?= Html::a('Volver', ['juegos/index'], ['class' => 'btn btn-primary']) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="juego-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <?php if (isset($respuesta)) : ?>
        <div class="select">
            <h3>Selecciona tu juego</h3>
            <?php
            if (is_array($respuesta)) :
                foreach ($respuesta as $key => $value) {
            ?>
                    <div>

                        <?= (Html::a($value->name, ['create-api', 'id' => $value->id])) ?>
                        <p><?= (isset($value->first_release_date) ? Yii::$app->formatter->asDate($value->first_release_date) : 'Aun no ha sido lanzado')  ?></p>
                    </div>
                <?php
                } else :
                ?>
                <div>

                    <?= (Html::a($respuesta->name, ['create-api', 'id' => $respuesta->id])) ?>
                    <p><?= (isset($respuesta->first_release_date) ? Yii::$app->formatter->asDate($respuesta->first_release_date) : 'Aun no ha sido lanzado')  ?></p>
                </div>
        </div>
    <?php endif ?>
<?php endif ?>
<?php if (isset($noEnc)) : ?>
    <p>No ha habido resultados.</p>

<?php endif ?>