<?php

namespace Anax\RemServer;

use Anax\Session\Session;
use PHPUnit\Framework\TestCase;

/**
 * Test for how to use RemServer.
 */
class RemServerUsageTest extends TestCase
{
    /**
     * @var RemServer $rem
     */
    private $rem;



    /**
     * Setup the remserver before each test.
     */
    public function setUp()
    {
        $this->rem = new RemServer();
        $session = new Session(["name" => "test"]);
        $config = require ANAX_INSTALL_PATH . "/config/remserver/config.php";
        $this->rem->setDefaultDataset($config["dataset"])
            ->injectSession($session)
            ->init();
    }



    /**
     * Check the default dataset is loaded.
     */
    public function testCheckDataSet()
    {
        $has = $this->rem->hasDataset();
        $this->assertTrue($has);
    }



    /**
     * Get a dataset.
     */
    public function testGetDataSet()
    {
        $set = $this->rem->getDataset("users");
        $exp = 12;
        $res = count($set);
        $this->assertEquals($exp, $res);

        $set = $this->rem->getDataset("books");
        $exp = 0;
        $res = count($set);
        $this->assertEquals($exp, $res);
    }



    /**
     * Set a dataset.
     */
    public function testSetDataSet()
    {
        $set = [];
        $obj = $this->rem->saveDataset("staff", $set);
        $this->assertEquals($this->rem, $obj);

        $set = $this->rem->getDataset("staff");
        $exp = 0;
        $res = count($set);
        $this->assertEquals($exp, $res);

        $set = $this->rem->getDataset("users");
        $this->rem->saveDataset("staff", $set);
        $set = $this->rem->getDataset("staff");
        $exp = 12;
        $res = count($set);
        $this->assertEquals($exp, $res);
    }



    /**
     * Get item from a dataset.
     */
    public function testGetItem()
    {
        $item = $this->rem->getItem("users", 1);
        $exp = "Allison";
        $res = $item["lastName"];
        $this->assertEquals($exp, $res);

        $item = $this->rem->getItem("book", 1);
        $this->assertNull($item);
    }



    /**
     * Add item to a dataset.
     */
    public function testSetItem()
    {
        $item = $this->rem->getItem("users", 1);
        $res  = $this->rem->addItem("students", $item);
        $this->assertEquals($item, $res);

        $item = $this->rem->getItem("users", 2);
        $res  = $this->rem->addItem("students", $item);
        $this->assertEquals($item, $res);
    }



    /**
     * Upsert/replace item to a dataset.
     */
    public function testUpsertItem()
    {
        $item = $this->rem->getItem("users", 1);
        $res  = $this->rem->upsertItem("teachers", 1, $item);
        $this->assertEquals($item, $res);

        $item = $this->rem->getItem("users", 2);
        $res  = $this->rem->upsertItem("teachers", 2, $item);
        $this->assertEquals($item, $res);

        $res  = $this->rem->upsertItem("teachers", 1, $item);
        $item = $this->rem->getItem("teachers", 1);
        $this->assertEquals($item, $res);
    }



    /**
     * Delete item from a dataset.
     */
    public function testDeleteItem()
    {
        $item = $this->rem->getItem("users", 1);
        $res  = $this->rem->upsertItem("managers", 1, $item);
        $this->assertEquals($item, $res);

        $item = $this->rem->getItem("users", 2);
        $res  = $this->rem->upsertItem("managers", 2, $item);
        $this->assertEquals($item, $res);

        $res  = $this->rem->deleteItem("managers", 1);
        $item = $this->rem->getItem("managers", 1);
        $this->assertNull($item);

        $res  = $this->rem->deleteItem("managers", 3);
        $item = $this->rem->getItem("managers", 3);
        $this->assertNull($item);

        $exp = $this->rem->getItem("users", 2);
        $res = $this->rem->getItem("managers", 2);
        $this->assertEquals($exp, $res);
    }
}
