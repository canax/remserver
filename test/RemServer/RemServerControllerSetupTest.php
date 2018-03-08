<?php

namespace Anax\RemServer;

use \Anax\DI\DIFactoryTest;

/**
 * Test for RemServerController.
 */
class RemServerControllerSetupTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Setup before each testcase
     */
    public function setUp()
    {
        $this->di = new DIFactoryTest();
        $this->di->configure("di.php");
    }



    /**
     * Create an object.
     */
    public function testCreate()
    {
        // Create using new
        $rem = new RemServerController();
        $this->assertInstanceOf("Anax\RemServer\RemServerController", $rem);

        // Inject needed
        $obj = $rem->setDI($this->di);
        $this->assertEquals($rem, $obj);

        // Create using $di
        $rem = $this->di->get("remController");
        $rem1 = $this->di->get("remController");
        $this->assertInstanceOf("Anax\RemServer\RemServerController", $rem);
        $this->assertEquals($rem, $rem1);
    }
}
