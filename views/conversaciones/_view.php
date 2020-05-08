<?php

use app\models\Conversaciones;
use yii\helpers\Html;


$last = $model->getLast();


?>
<div class="conversation-view">
    <div>
        <p><?= Html::a($last->sender->username, ['view', 'id' => $model->id]) ?></p>
        <p><?= $last->sender->username ?>: <?= Html::encode($last->cuerpo) ?> - <?= Yii::$app->formatter->asDatetime($last->created_at) ?></p>
    </div>
</div>