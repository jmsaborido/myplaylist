<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

AppAsset::register($this);
$this->title = 'Conversaciones';
?>
<div class="conversacions-index">

    <p>
        <?= Html::a('Nuevo Mensaje', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'conversacion-item'],
        'layout' => "{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_view.php', [
                'model' => $model,
                'index' => $index,
            ]);
        }
    ]) ?>
</div>