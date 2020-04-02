<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consolas */

$this->title = 'Create Consolas';
$this->params['breadcrumbs'][] = ['label' => 'Consolas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consolas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
