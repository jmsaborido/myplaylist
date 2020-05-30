<?php

use app\models\Usuarios;

class JuegosCest
{
    public function _before(\FunctionalTester $I)
    {

        $I->amOnRoute('juegos/index');
    }
    public function openIndexPage(\FunctionalTester $I)
    {
        $I->see('Lista de Juegos', 'h1');
    }

    public function guestUser(\FunctionalTester $I)
    {
        $I->dontSee('', 'th.action-column');
    }

    public function loggedUser(\FunctionalTester $I)
    {
        $I->amLoggedInAs(Usuarios::findOne(1));
        $I->amOnRoute('juegos/index');
        $I->see('', 'th.action-column');
    }

    public function table(\FunctionalTester $I)
    {
        $I->see('Nombre', 'table');
    }
}
