<?php

namespace Anax\RemServer;

use Anax\Session\Session;
use PHPUnit\Framework\TestCase;

/**
 * Test for modelclass RemServer.
 */
class RemServerSetupTest extends TestCase
{
    /**
     * Create an object.
     */
    public function testCreate()
    {
        $rem = new RemServer();
        $this->assertInstanceOf("Anax\RemServer\RemServer", $rem);
    }



    /**
     * Check that the default dataset can be set and and returns instance.
     */
    public function testSetDefaultDataSet()
    {
        $rem = new RemServer();
        $obj = $rem->setDefaultDataset(["some" => "value"]);
        $this->assertEquals($rem, $obj);
    }



    /**
     * Check that the default dataset can be set and retrieved.
     */
    public function testGetDefaultDataSet()
    {
        $rem = new RemServer();
        $dataset = ["some" => "value"];
        $rem->setDefaultDataset($dataset);
        $res = $rem->getDefaultDataset();
        $this->assertEquals($dataset, $res);
    }



    /**
     * Inject a session.
     */
    public function testInjectSession()
    {
        $rem     = new RemServer();
        $session = new Session(["name" => "test"]);
        $obj = $rem->injectSession($session);
        $this->assertEquals($rem, $obj);
    }



    /**
     * Load default configuration file.
     */
    public function testLoadDefaultConfigFile()
    {
        $config = require ANAX_INSTALL_PATH . "/config/remserver/config.php";
        $dataset = $config["dataset"] ?? null;
        $this->assertArrayHasKey("dataset", $config);
        $this->assertInternalType("array", $dataset);
    }



    /**
     * Allow init with empty dataset.
     */
    public function testEmptyDatasetAllowed()
    {
        $rem = new RemServer();
        $session = new Session(["name" => "test"]);

        $obj = $rem->setDefaultDataset([])
            ->injectSession($session)
            ->init();
        $this->assertEquals($rem, $obj);
    }



    /**
     * Make all steps to init the remserver.
     */
    public function testInit()
    {
        $rem = new RemServer();
        $session = new Session(["name" => "test"]);

        $config = require ANAX_INSTALL_PATH . "/config/remserver/config.php";
        $dataset = $config["dataset"] ?? null;

        $obj = $rem->setDefaultDataset($dataset)
            ->injectSession($session)
            ->init();
        $this->assertEquals($rem, $obj);
    }
}
