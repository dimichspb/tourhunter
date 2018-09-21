<?php
namespace app\tests\functional;

class SiteControllerCest
{
    /**
     * Test index page
     * @param \FunctionalTester $I
     */
    public function openIndexPage(\FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
        $I->see('Welcome!', 'h1');
    }
}