<?php


use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use Jschubert\Igdb\Builder\SearchBuilder;


/* @var $this yii\web\View */
/* @var $model app\models\Juegos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="juegos-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->nombre == "josesabor") : ?>

        <p>
            <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif ?>

    <?php
    $searchBuilder = new SearchBuilder(Yii::$app->params['igdb']['key']);
    $searchBuilder2 = new SearchBuilder(Yii::$app->params['igdb']['key']);

    //Add endpoint and search by id.
    $imagen = $searchBuilder
        ->addEndpoint('games')
        ->addFields(['id', 'name'])
        ->addSearch($model->nombre)
        ->search()
        ->get();

    Yii::debug($imagen);

    $url = $searchBuilder2
        ->addEndpoint('images')
        ->searchById($imagen->id, ["game"])
        ->get();

    Yii::debug($url);

    ?>
    <?=
        // $url->url
        Html::img("juan")
    ?>

    <?=

        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'fecha',
                'nombre',
                'consola.denom',
                'pasado:boolean',
                'genero.denom',
                'year_debut',
            ],
        ]) ?>

</div>