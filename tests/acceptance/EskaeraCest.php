<?php

class EskaeraCest
{
    public function _before(AcceptanceTester $I): void
    {
    }

    // tests
    public function EskaeraOporrakOrduakTest(AcceptanceTester $I): void
    {
        $I->amGoingTo('Test Opor Eskaera');
        $I->amOnPage('/eskaera/instantziak');
        $I->dontSee('Aukeratu instantzia mota');

        $I->amGoingTo('Login like iibarguren');
        $I->amOnPage('/login');
        $I->fillField('#username', 'iibarguren');
        $I->fillField('#password', 'pasatrin');
        $I->click('#_submit');

        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
        $I->click('Instantzia berria');
        $I->see('Aukeratu instantzia mota');
        $I->dontSee('Aukeratu eta jarraitu');
        $I->click('#spanoporrak');
        $I->see('Aukeratu eta jarraitu');
        $I->click('#eskaeraoporrak');
        $I->see('Oporrak eskaera berria ');



        $I->fillField('#appbundle_eskaera_hasi', '2019-08-19');
        $I->pressKey('#appbundle_eskaera_hasi', WebDriverKeys::TAB);
        $I->fillField('#appbundle_eskaera_amaitu', '2019-08-19');
        $I->pressKey('#appbundle_eskaera_amaitu', WebDriverKeys::TAB);
        $I->click('//*[@id="cmdDivOrduak"]');
        $I->fillField('#appbundle_eskaera_oharra', 'Test eskaera oporrk orduak');
        $I->fillField('#appbundle_eskaera_orduak', '2');
        $I->click(['id'=>'btnSubmit']);
        $I->see('Eskaera gauzatu da');

        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('248.00 (34.16 egun)', '#hoursFree');

        $I->amGoingTo('Remove eskaera and see if its rollback correctly');
        $I->amOnPage('/eskaera/');
        $I->seeNumberOfElements('tr', 2);
        $I->click('.btnRemoveEskaera');
        try {
            $I->waitForElementVisible('.bootbox');
        } catch (Exception $e) {
        } // waiting it to show
        $I->see('Adi!', '.bootbox'); // text inside modal
        $I->click('.btn-primary', '.bootbox'); // clicking ok insode modal
        $I->see('Ez dago daturik');

        $I->amGoingTo('Egutegiko orduak lehengoratu direla.');
        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
    }

    public function EskaeraOporrakEgunak(AcceptanceTester $I): void
    {
        $I->amGoingTo('Test Opor Eskaera');
        $I->amOnPage('/eskaera/instantziak');
        $I->dontSee('Aukeratu instantzia mota');

        $I->amGoingTo('Login like iibarguren');
        $I->amOnPage('/login');
        $I->fillField('#username', 'iibarguren');
        $I->fillField('#password', 'pasatrin');
        $I->click('#_submit');

        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
        $I->click('Instantzia berria');
        $I->see('Aukeratu instantzia mota');
        $I->dontSee('Aukeratu eta jarraitu');
        $I->click('#spanoporrak');
        $I->see('Aukeratu eta jarraitu');
        $I->click('#eskaeraoporrak');
        $I->see('Oporrak eskaera berria ');

        $I->fillField('#appbundle_eskaera_hasi', '2019-08-19');
        $I->pressKey('#appbundle_eskaera_hasi', WebDriverKeys::TAB);
        $I->fillField('#appbundle_eskaera_amaitu', '2019-08-20');
        $I->pressKey('#appbundle_eskaera_amaitu', WebDriverKeys::TAB);
        $I->click('//*[@id="cmdDivEgunak"]');
        $I->see('2.00', '#appbundle_eskaera_egunak');
        $I->see('14.52', '#appbundle_eskaera_total');

        $I->fillField('#appbundle_eskaera_oharra', 'Test eskaera oporrak egunak');

        $I->click(['id'=>'btnSubmit']);
        $I->see('Eskaera gauzatu da');

        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('235.48 (32.44 egun)', '#hoursFree');

        $I->amGoingTo('Remove eskaera and see if its rollback correctly');
        $I->amOnPage('/eskaera/');
        $I->seeNumberOfElements('tr', 2);
        $I->click('.btnRemoveEskaera');
        try {
            $I->waitForElementVisible('.bootbox');
        } catch (Exception $e) {
        } // waiting it to show
        $I->see('Adi!', '.bootbox'); // text inside modal
        $I->click('.btn-primary', '.bootbox'); // clicking ok insode modal
        $I->see('Ez dago daturik');

        $I->amGoingTo('Egutegiko orduak lehengoratu direla.');
        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
    }

    public function EskaeraSindikalaOrduakTest(AcceptanceTester $I): void
    {
        $I->amGoingTo('Test Ordu sindikalak Eskaera');
        $I->amOnPage('/eskaera/instantziak');
        $I->dontSee('Aukeratu instantzia mota');

        $I->amGoingTo('Login like iibarguren');
        $I->amOnPage('/login');
        $I->fillField('#username', 'iibarguren');
        $I->fillField('#password', 'pasatrin');
        $I->click('#_submit');

        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('30.00', '#hoursSindikal');
        $I->click('Instantzia berria');
        $I->see('Aukeratu instantzia mota');
        $I->dontSee('Aukeratu eta jarraitu');
        $I->click('#spanordu-sindikalak');
        $I->see('Aukeratu eta jarraitu');
        $I->click('#eskaeraordu-sindikalak');
        $I->see('Ordu Sindikalak eskaera berria');

        $I->fillField('#appbundle_eskaera_hasi', '2019-08-19');
        $I->pressKey('#appbundle_eskaera_hasi', WebDriverKeys::TAB);
        $I->fillField('#appbundle_eskaera_amaitu', '2019-08-19');
        $I->pressKey('#appbundle_eskaera_amaitu', WebDriverKeys::TAB);

        $I->click('//*[@id="cmdDivOrduak"]');
        $I->fillField('#appbundle_eskaera_oharra', 'Test eskaera oporrk orduak');
        $I->fillField('#appbundle_eskaera_orduak', '2');
        $I->click(['id'=>'btnSubmit']);
        $I->see('Eskaera gauzatu da');

        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('28.00', '#hoursSindikal');

        $I->amGoingTo('Remove eskaera and see if its rollback correctly');
        $I->amOnPage('/eskaera/');
        $I->seeNumberOfElements('tr', 2);
        $I->click('.btnRemoveEskaera');
        try {
            $I->waitForElementVisible('.bootbox');
        } catch (Exception $e) {
        } // waiting it to show
        $I->see('Adi!', '.bootbox'); // text inside modal
        $I->click('.btn-primary', '.bootbox'); // clicking ok insode modal
        $I->see('Ez dago daturik');

        $I->amGoingTo('Egutegiko orduak lehengoratu direla.');
        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('30.00', '#hoursSindikal');
    }

    public function EskaeraSindikalaEgunakTest(AcceptanceTester $I): void
    {
        $I->amGoingTo('Test Egun sindikalak Eskaera');
        $I->amOnPage('/eskaera/instantziak');
        $I->dontSee('Aukeratu instantzia mota');

        $I->amGoingTo('Login like iibarguren');
        $I->amOnPage('/login');
        $I->fillField('#username', 'iibarguren');
        $I->fillField('#password', 'pasatrin');
        $I->click('#_submit');

        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('30.00', '#hoursSindikal');
        $I->click('Instantzia berria');
        $I->see('Aukeratu instantzia mota');
        $I->dontSee('Aukeratu eta jarraitu');
        $I->click('#spanordu-sindikalak');
        $I->see('Aukeratu eta jarraitu');
        $I->click('#eskaeraordu-sindikalak');
        $I->see('Ordu Sindikalak eskaera berria');

        $I->fillField('#appbundle_eskaera_hasi', '2019-08-19');
        $I->pressKey('#appbundle_eskaera_hasi', WebDriverKeys::TAB);
        $I->fillField('#appbundle_eskaera_amaitu', '2019-08-20');
        $I->pressKey('#appbundle_eskaera_amaitu', WebDriverKeys::TAB);
        $I->click('//*[@id="cmdDivEgunak"]');
        $I->see('2.00', '#appbundle_eskaera_egunak');
        $I->see('14.52', '#appbundle_eskaera_total');
        $I->fillField('#appbundle_eskaera_oharra', 'Test eskaera sindikal egunak');
        $I->click(['id'=>'btnSubmit']);
        $I->see('Eskaera gauzatu da');

        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('15.48', '#hoursSindikal');

        $I->amGoingTo('Remove eskaera and see if its rollback correctly');
        $I->amOnPage('/eskaera/');
        $I->seeNumberOfElements('tr', 2);
        $I->click('.btnRemoveEskaera');
        try {
            $I->waitForElementVisible('.bootbox');
        } catch (Exception $e) {
        } // waiting it to show
        $I->see('Adi!', '.bootbox'); // text inside modal
        $I->click('.btn-primary', '.bootbox'); // clicking ok insode modal
        $I->see('Ez dago daturik');

        $I->amGoingTo('Egutegiko orduak lehengoratu direla.');
        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('30.00', '#hoursSindikal');
    }

    public function EskaeraLizentziaOrduakTest(AcceptanceTester $I): void
    {
        $I->amGoingTo('Test Lizentzia Eskaera');
        $I->amOnPage('/eskaera/instantziak');
        $I->dontSee('Aukeratu instantzia mota');

        $I->amGoingTo('Login like iibarguren');
        $I->amOnPage('/login');
        $I->fillField('#username', 'iibarguren');
        $I->fillField('#password', 'pasatrin');
        $I->click('#_submit');

        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('9.37', '#hoursCompensed');
        $I->see('30.00', '#hoursSindikal');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
        $I->see('29.04 ordu (4 egun)', '#hoursSelf');
        $I->see('14.52', '#selfHoursPartial');
        $I->see('( 14 ordu 31 minutu )', '#selfHoursPartialToHour');
        $I->see('29.04 (4 egun)', '#selfHoursComplete');


        $I->click('Instantzia berria');
        $I->see('Aukeratu instantzia mota');
        $I->dontSee('Aukeratu eta jarraitu');
        $I->click('#spanlizentziak');
        $I->see('Aukeratu eta jarraitu');
        $I->click('#eskaeralizentziak');
        $I->see('Lizentziak eskaera berria ');

        $I->fillField('#appbundle_eskaera_hasi', '2019-08-19');
        $I->pressKey('#appbundle_eskaera_hasi', WebDriverKeys::TAB);
        $I->fillField('#appbundle_eskaera_amaitu', '2019-08-20');
        $I->pressKey('#appbundle_eskaera_amaitu', WebDriverKeys::TAB);

        $I->click('//*[@id="cmdDivOrduak"]');
        $I->fillField('#appbundle_eskaera_oharra', 'Test Lizentzia orduak');
        $I->fillField('#appbundle_eskaera_orduak', '2');
        $I->click(['id'=>'btnSubmit']);
        try {
            $I->waitForElementVisible('.bootbox');
        } catch (Exception $e) {
        } // waiting it to show
        $I->see('Lizentzia mota zehaztea beharrezkoa da', '.bootbox'); // text inside modal
        $I->click('.btn-primary', '.bootbox'); // clicking ok insode modal
        $option = $I->grabTextFrom('#appbundle_eskaera_lizentziamota option:nth-child(3)');
        $I->selectOption('#appbundle_eskaera_lizentziamota', $option);
        $I->seeInField('#appbundle_eskaera_lizentziamota', 'AZTERKETAK');
        $I->attachFile('#appbundle_eskaera_justifikanteFile_file', 'txankete.jpeg');
        $I->click(['id'=>'btnSubmit']);
        $I->see('Eskaera gauzatu da');

        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('9.37', '#hoursCompensed');
        $I->see('30.00', '#hoursSindikal');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
        $I->see('29.04 ordu (4 egun)', '#hoursSelf');
        $I->see('14.52', '#selfHoursPartial');
        $I->see('( 14 ordu 31 minutu )', '#selfHoursPartialToHour');
        $I->see('29.04 (4 egun)', '#selfHoursComplete');

        $I->amGoingTo('Remove eskaera and see if its rollback correctly');
        $I->amOnPage('/eskaera/');
        $I->seeNumberOfElements('tr', 2);
        $I->see('Ikusi justifikatea');

        $I->amGoingTo('Atxikitutako fitxategia kendu eta berriz bidaltzen.');
        $miid = $I->grabTextFrom('#tableEskaerak tbody tr td:nth-of-type(1)');
        $I->click('.btnFileDelete-'.$miid);
        $I->see('Justifikatea bidali');

        $I->click('.btnFileSend-'.$miid);
        $I->see('Justifikantea gehitu');
        $I->attachFile('#appbundle_eskaera_justifikanteFile_file', 'txankete.jpeg');
        $I->click('#btnSendJustify');
        $I->see('Instantzien zerrenda');
        $I->seeNumberOfElements('tr', 2);
        $I->see('Ikusi justifikatea');

        $I->click('.btnRemoveEskaera');
        try {
            $I->waitForElementVisible('.bootbox');
        } catch (Exception $e) {
        } // waiting it to show
        $I->see('Adi!', '.bootbox'); // text inside modal
        $I->click('.btn-primary', '.bootbox'); // clicking ok insode modal
        $I->see('Ez dago daturik');

        $I->amGoingTo('Egutegiko orduak lehengoratu direla.');
        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('9.37', '#hoursCompensed');
        $I->see('30.00', '#hoursSindikal');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
        $I->see('29.04 ordu (4 egun)', '#hoursSelf');
        $I->see('14.52', '#selfHoursPartial');
        $I->see('( 14 ordu 31 minutu )', '#selfHoursPartialToHour');
        $I->see('29.04 (4 egun)', '#selfHoursComplete');
    }

    public function EskaeraLizentziaEgunakTest(AcceptanceTester $I): void
    {
        $I->amGoingTo('Test Lizentzia Eskaera');
        $I->amOnPage('/eskaera/instantziak');
        $I->dontSee('Aukeratu instantzia mota');

        $I->amGoingTo('Login like iibarguren');
        $I->amOnPage('/login');
        $I->fillField('#username', 'iibarguren');
        $I->fillField('#password', 'pasatrin');
        $I->click('#_submit');

        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('9.37', '#hoursCompensed');
        $I->see('30.00', '#hoursSindikal');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
        $I->see('29.04 ordu (4 egun)', '#hoursSelf');
        $I->see('14.52', '#selfHoursPartial');
        $I->see('( 14 ordu 31 minutu )', '#selfHoursPartialToHour');
        $I->see('29.04 (4 egun)', '#selfHoursComplete');


        $I->click('Instantzia berria');
        $I->see('Aukeratu instantzia mota');
        $I->dontSee('Aukeratu eta jarraitu');
        $I->click('#spanlizentziak');
        $I->see('Aukeratu eta jarraitu');
        $I->click('#eskaeralizentziak');
        $I->see('Lizentziak eskaera berria ');

        $I->fillField('#appbundle_eskaera_hasi', '2019-08-19');
        $I->pressKey('#appbundle_eskaera_hasi', WebDriverKeys::TAB);
        $I->fillField('#appbundle_eskaera_amaitu', '2019-08-20');
        $I->pressKey('#appbundle_eskaera_amaitu', WebDriverKeys::TAB);

        $I->click('//*[@id="cmdDivEgunak"]');
        $I->fillField('#appbundle_eskaera_oharra', 'Test Lizentzia egunak');
        $I->see('2.00', '#appbundle_eskaera_egunak');
        $I->see('14.52', '#appbundle_eskaera_total');
        $I->click(['id'=>'btnSubmit']);
        try {
            $I->waitForElementVisible('.bootbox');
        } catch (Exception $e) {
        } // waiting it to show
        $I->see('Lizentzia mota zehaztea beharrezkoa da', '.bootbox'); // text inside modal
        $I->click('.btn-primary', '.bootbox'); // clicking ok insode modal
        $option = $I->grabTextFrom('#appbundle_eskaera_lizentziamota option:nth-child(3)');
        $I->selectOption('#appbundle_eskaera_lizentziamota', $option);
        $I->seeInField('#appbundle_eskaera_lizentziamota', 'AZTERKETAK');
        $I->attachFile('#appbundle_eskaera_justifikanteFile_file', 'txankete.jpeg');
        $I->click(['id'=>'btnSubmit']);
        $I->see('Eskaera gauzatu da');

        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('9.37', '#hoursCompensed');
        $I->see('30.00', '#hoursSindikal');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
        $I->see('29.04 ordu (4 egun)', '#hoursSelf');
        $I->see('14.52', '#selfHoursPartial');
        $I->see('( 14 ordu 31 minutu )', '#selfHoursPartialToHour');
        $I->see('29.04 (4 egun)', '#selfHoursComplete');

        $I->amGoingTo('Remove eskaera and see if its rollback correctly');
        $I->amOnPage('/eskaera/');
        $I->seeNumberOfElements('tr', 2);
        $I->see('Ikusi justifikatea');

        $I->amGoingTo('Atxikitutako fitxategia kendu eta berriz bidaltzen.');
        $miid = $I->grabTextFrom('#tableEskaerak tbody tr td:nth-of-type(1)');
        $I->click('.btnFileDelete-'.$miid);
        $I->see('Justifikatea bidali');

        $I->click('.btnFileSend-'.$miid);
        $I->see('Justifikantea gehitu');
        $I->attachFile('#appbundle_eskaera_justifikanteFile_file', 'txankete.jpeg');
        $I->click('#btnSendJustify');
        $I->see('Instantzien zerrenda');
        $I->seeNumberOfElements('tr', 2);
        $I->see('Ikusi justifikatea');

        $I->click('.btnRemoveEskaera');
        try {
            $I->waitForElementVisible('.bootbox');
        } catch (Exception $e) {
        } // waiting it to show
        $I->see('Adi!', '.bootbox'); // text inside modal
        $I->click('.btn-primary', '.bootbox'); // clicking ok insode modal
        $I->see('Ez dago daturik');

        $I->amGoingTo('Egutegiko orduak lehengoratu direla.');
        $I->amOnPage('/mycalendar');
        $I->see('IKER IBARGUREN BERASALUZE');
        $I->see('9.37', '#hoursCompensed');
        $I->see('30.00', '#hoursSindikal');
        $I->see('250.00 (34.44 egun)', '#hoursFree');
        $I->see('29.04 ordu (4 egun)', '#hoursSelf');
        $I->see('14.52', '#selfHoursPartial');
        $I->see('( 14 ordu 31 minutu )', '#selfHoursPartialToHour');
        $I->see('29.04 (4 egun)', '#selfHoursComplete');
    }
}
