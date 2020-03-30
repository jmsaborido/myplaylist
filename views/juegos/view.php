<?php


use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use Jschubert\Igdb\Builder\SearchBuilder;
use yii\bootstrap4\Carousel;

/* @var $this yii\web\View */
/* @var $model app\models\Juegos */

$searchBuilder = new SearchBuilder(Yii::$app->params['igdb']['key']);
$searchBuilder2 = new SearchBuilder(Yii::$app->params['igdb']['key']);
$searchBuilder3 = new SearchBuilder(Yii::$app->params['igdb']['key']);
$searchBuilder4 = new SearchBuilder(Yii::$app->params['igdb']['key']);

//Add endpoint and search by id.
$respuesta = $searchBuilder
    ->addEndpoint('games')
    ->searchById($model->id, ['*'])
    ->get();

$genero = $searchBuilder2
    ->addEndpoint('genres')
    ->searchById($respuesta->genres[0], ['*'])
    ->get();
$fecha = $searchBuilder3
    ->addEndpoint('release_dates')
    ->addFields(['*'])
    ->addFilter('game', '=', $model->id)
    ->search()
    ->get();
$imagen = $searchBuilder4
    ->addEndpoint('games')
    ->searchById($model->id, ['screenshots.*'])
    ->get();

// Yii::debug($imagen);
// Yii::debug($genero);

$this->title = $respuesta->name;
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
    <?php endif; ?>

    <?= Html::img($imagen->screenshots['0']->url) ?>


    <ul>
        <li><?= $respuesta->summary ?></li>
        <li><?= $genero->name ?></li>
        <li>Fecha de salida: <?= Yii::$app->formatter->asDate($fecha[0]->date) ?></li>
    </ul>


</div>