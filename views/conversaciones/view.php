<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$js = <<<EOT
var element = document.getElementById("list");
element.scrollTop = element.scrollHeight;
element.scrollTop = element.scrollTop;
$(document).on('ready', ()=> {
    $('.field-message-content #message-content').focus();
});
EOT;
$this->registerJs($js);
$templateMessage = '{label}<div class="input-group">{input}
<span class="input-group-btn">
    <button type="submit" class="btn btn-primary" name="sender">Enviar</button>
</span></div>{hint}{error}';

?>
<?= Html::a('Volver A Las Conversaciones', Url::to(['conversaciones/index']), ['class' => 'btn btn-primary']) ?>
<h3>Hola</h3>
<div class="list" id="list">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'options' => [
            'tag' => 'div',
            'class' => 'message-wrapper',
            'id' => 'message-wrapper',
        ],
        'layout' => "{items}\n{pager}",
        'itemView' => '../mensajes/_view.php',
    ]) ?>
</div>
<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($mensaje, 'cuerpo', ['template' => $templateMessage, 'inputOptions' => [
        'autocomplete' => 'off', 'class' => 'form-control'
    ]])->textInput()->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>