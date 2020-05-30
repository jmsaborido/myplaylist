<?php

use Symfony\Component\DomCrawler\Form;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Completados */

$this->title = $respuesta->name . " completado por " . $model->usuario->username;
$this->params['breadcrumbs'][] = ['label' => 'Completados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="completados-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mb-3">
        <div class="col text-center">
            <?= Html::img('https://images.igdb.com/igdb/image/upload/t_cover_big/' .  $model->juego->img_api . '.jpg', ['height' => '200px']) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-borderless detail-view'],
        'attributes' => [
            'fecha:date',
            'pasado:boolean',
            [
                'attribute' => 'consola.denom',
                'label' => 'Completado en',
            ],
            [
                'label' => 'Fecha de salida',
                'value' =>  $respuesta->first_release_date,
                'format' => 'date'
            ],
            [
                'label' => 'Todos los generos',
                'value' =>  $generos
            ],
            [
                'label' => 'Puntuacion media',
                'value' => isset($respuesta->total_rating) ? round($respuesta->total_rating) : null,
            ]
        ],
    ]) ?>

    <?php if (!Yii::$app->user->isGuest && $model->usuario_id === Yii::$app->user->id) : ?>

        <p>
            <?= Html::a('Modificar', ['update', 'id' => $model->id],  ['class' => 'btn btn-success', 'id' => 'modificar']) ?>
            <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif ?>


    <?php if ($comentarios != null) ?>
    <article class="comentarios">
        <h2>Comentarios</h2>
        <?php foreach ($comentarios as $key => $value) { ?>
            <section id="comentario" class="row justify-content-between">
                <p id="cuerpo">
                    <?= Html::a(Html::encode($value->usuario->username), ['usurios/view', 'id' => $value->usuario_id]) . " : " .
                        Html::encode($value->cuerpo) . " " . "</p> <p id='fecha'>" .
                        Yii::$app->formatter->asDateTime($value->created_at) .
                        ($value->usuario_id === Yii::$app->user->id ?
                            Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                ['comentarios-completados/update', 'id' => $value->id]
                            ) . Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                ['comentarios-completados/delete', 'id' => $value->id,],
                                ['data-method' => 'post']
                            ) : " ")
                    ?>
                </p>
            </section> <?php } ?>
    </article> <?php if (!Yii::$app->user->isGuest) : ?> <?php $form = ActiveForm::begin(['action' => ['comentarios-completados/comentar']]);
                                                            ?> <?= $form->field($model2, 'cuerpo')->label(false) ?> <?= $form->field($model2, 'id')->hiddenInput(['value' => $model->id])->label(false) ?> <div class="form-group">
            <?= Html::submitButton('Comentar', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    <?php endif ?>








</div>
</div>