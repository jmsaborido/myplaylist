<?php

use yii\helpers\Html;

$sender = $model->sender->id == Yii::$app->user->id ? 'sender' : 'nosender';
Yii::debug($sender);

?>
<div id="<?= $sender ?>" class="message-view <?= $sender ?>">
    <p><?= $model->sender->username . " : " . $model->cuerpo ?></p>
</div>