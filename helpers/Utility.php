<?php

namespace app\helpers;

use Yii;

/**
 * Clase auxiliar
 */
class Utility
{
    /**
     * Calcula la media de un array recibido
     *
     * @param [] $array El array de numeros recibidos
     * @return int la media de los numeros recibidos
     */
    public static function media($array)
    {
        $array = array_filter($array);
        return array_sum($array) / count($array);
    }
    /**
     * Calcula la moda de un array recibido
     *
     * @param [] $array El array de numeros recibidos
     * @return int la moda de los numeros recibidos
     */
    public static function moda($array)
    {
        $values = array_count_values($array);
        return  array_search(max($values), $values);
    }

    /**
     * Envia un correo
     *
     * @param string $cuerpo el cuerpo del correo
     * @param string $dest el destinatario
     * @param string $subject el asunto
     * @return void
     */
    public function enviarMail($cuerpo, $dest, $subject)
    {
        return Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['smtpUsername'])
            ->setTo($dest)
            ->setSubject($subject)
            ->setHtmlBody($cuerpo)
            ->send();
    }
}
