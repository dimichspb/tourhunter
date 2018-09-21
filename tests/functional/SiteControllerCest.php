<?php
namespace app\tests\functional;

class SiteControllerCest
{
    public function openIndexPage(\FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
        $I->see('Welcome!', 'h1');
    }
}