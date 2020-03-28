<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Completados */

$this->title = 'Create Completados';
$this->params['breadcrumbs'][] = ['label' => 'Completados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="completados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
