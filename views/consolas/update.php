<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consolas */

$this->title = 'Modificando la consola: ' . $model->denom;
$this->params['breadcrumbs'][] = ['label' => 'Consolas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="consolas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>