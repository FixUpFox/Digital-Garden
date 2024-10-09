<?php

namespace Tests\EndToEnd;

use Tests\Support\EndToEndTester;

class ActivationCest
{
    public function test_it_deactivates_activates_correctly(EndToEndTester $I): void
    {
        $I->loginAsAdmin();
        $I->amOnPluginsPage();

        $I->seePluginActivated('digital-garden');

        $I->deactivatePlugin('digital-garden');

        $I->seePluginDeactivated('digital-garden');

        $I->activatePlugin('digital-garden');

        $I->seePluginActivated('digital-garden');
    }
}
