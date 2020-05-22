<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RecomendarForm is the model behind the contact form.
 */
class RecomendarForm extends Model
{
    public $email;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Correo electronico',
        ];
    }
}
