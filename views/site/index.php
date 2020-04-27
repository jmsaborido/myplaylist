<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'MyPlayList';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>¡Bienvenido!</h1>

        <p class="lead">Podrás usar esta página para mantener un registro de tus juegos completados.</p>

        <p><?= Html::a('Clicka aquí para ver tú lista', ['/completados/index'], ['class' => "btn btn-lg btn-outline-success"]) ?></p>
    </div>
    <div class="body-content">

        <div class="row">
            <div class="col-xl-4">
                <h2>Géneros</h2>

                <p>Aquí podrás ver todos los géneros que tenemos en nuestra base de datos</p>

                <p><?= Html::a('Géneros', ['/generos/index'], ['class' => "btn btn-outline-info"]) ?></p>
            </div>
            <div class="col-xl-4">
                <h2>Consolas</h2>

                <p>Aquí podrás ver todas las consolas que tenemos en nuestra base de datos</p>

                <p><?= Html::a('Consolas', ['/consolas/index'], ['class' => "btn btn-outline-info"]) ?></p>
            </div>
            <div class="col-xl-4">
                <h2>Usuarios</h2>

                <p>Aqui podras buscar a los usuarios</p>

                <p><?= Html::a('Usuarios', ['/usuarios/index'], ['class' => "btn btn-outline-info"]) ?></p>
            </div>
        </div>

    </div>
</div>