<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use PHPUnit\Framework\Assert;

/**
 * Defines instrument related features.
 */
trait InstrumentDictionary
{
    /**
     * @var string
     */
    private $instrumentId;

    /**
     * @Given /^I create an instrument with pgjs$/
     */
    public function iCreateAnInstrumentWithPgjs()
    {

        $driver = RemoteWebDriver::create('http://selenium:4444', DesiredCapabilities::firefox());
        $driver->get('http://host.docker.internal/payment_v3_create_instrument.php?' .
            http_build_query([
                'publicKey' => getenv('PUBLIC_KEY'),
            ]));

        // Wait until iframe is loaded
        $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#paygreen-pan-frame iframe'))
        );

        // Fill pan field
        $iframe = $driver->findElement(WebDriverBy::id('cardNumberFrame'));
        $driver->switchTo()->frame($iframe);
        $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="pan"]'))
        );
        $driver->findElement(WebDriverBy::name('pan'))->sendKeys(getenv('BANK_CARD_PAN'));

        // Fill cvc field
        $driver->switchTo()->defaultContent();
        $iframe = $driver->findElement(WebDriverBy::id('cvvFrame'));
        $driver->switchTo()->frame($iframe);
        $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="cvv"]'))
        );
        $driver->findElement(WebDriverBy::name('cvv'))->sendKeys(getenv('BANK_CARD_CVV'));

        // Fill expiration field
        $driver->switchTo()->defaultContent();
        $iframe = $driver->findElement(WebDriverBy::id('expFrame'));
        $driver->switchTo()->frame($iframe);
        $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="exp"]'))
        );
        $driver->findElement(WebDriverBy::name('exp'))->sendKeys(getenv('BANK_CARD_EXP'));

        // Submit form
        $driver->switchTo()->defaultContent();
        $driver->executeScript('paygreenjs.submitPayment()');

        $driver->wait()->until(
            function ($driver) {
                return $driver->executeScript('return instrumentId !== null');
            }
        );

        $this->instrumentId = $driver->executeScript('return instrumentId');
        $driver->quit();

        Assert::assertNotNull($this->instrumentId);

        print $this->instrumentId;
    }
}
