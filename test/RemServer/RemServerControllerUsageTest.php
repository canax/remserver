<?php

namespace Anax\RemServer;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test for using the RemServerController.
 */
class RemServerControllerUsageTest extends TestCase
{
    /**
     * @var Anax\DI\DIFactoryConfig            $di
     * @var Anax\RemServer\RemServerController $controller
     */
    private $di;
    private $controller;



    /**
     * Setup before each testcase
     */
    protected function setUp()
    {
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        $this->controller = new RemServerController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Tear down after each testcase
     */
    protected function tearDown()
    {
        $this->di->get("session")->destroy();
    }



    /**
     * Explicitly init the rem server.
     */
    public function testInitActionGet()
    {
        $res = $this->controller->initActionGet();
        $this->assertInternalType("array", $res);
        $this->assertInternalType("array", $res[0]);
        $this->assertContains("is initiated", $res[0]["message"]);
    }



    /**
     * Get the default dataset.
     */
    public function testGetDefaultDataset()
    {
        $this->controller->initActionGet();
        $res = $this->controller->getDataset("users");
        $this->assertInternalType("array", $res);
        $this->assertInternalType("array", $res[0]);

        $json = $res[0];
        $item = $json["data"][0];
        $this->assertEquals(1, $item["id"]);
        $this->assertEquals("Phuong", $item["firstName"]);
        $this->assertEquals("Allison", $item["lastName"]);

        $this->assertEquals(0, $json["offset"]);
        $this->assertEquals(25, $json["limit"]);
        $this->assertEquals(12, $json["total"]);
    }



    /**
     * Get first parts of default dataset, no offset.
     */
    public function testGetFirstPartsOfDefaultDataset()
    {
        $this->controller->initActionGet();

        $this->di->get("request")->setGlobals([
            "get" => [
                "offset" => 0,
                "limit" => 2,
            ]
        ]);
        $res = $this->controller->getDataset("users");
        $json = $res[0];
        $this->assertEquals(2, count($json["data"]));
        $this->assertEquals(1, $json["data"][0]["id"]);
        $this->assertEquals(2, $json["data"][1]["id"]);
        $this->assertEquals(0, $json["offset"]);
        $this->assertEquals(2, $json["limit"]);
        $this->assertEquals(12, $json["total"]);
    }



    /**
     * Get middle parts of default dataset, with offset.
     */
    public function testGetMiddlePartsOfDefaultDataset()
    {
        $this->controller->initActionGet();

        $this->di->get("request")->setGlobals([
            "get" => [
                "offset" => 2,
                "limit" => 2,
            ]
        ]);
        $res = $this->controller->getDataset("users");
        $json = $res[0];
        $this->assertEquals(2, count($json["data"]));
        $this->assertEquals(3, $json["data"][0]["id"]);
        $this->assertEquals(4, $json["data"][1]["id"]);
        $this->assertEquals(2, $json["offset"]);
        $this->assertEquals(2, $json["limit"]);
        $this->assertEquals(12, $json["total"]);
    }



    /**
     * Get last parts of default dataset, with offset + limit exceeding.
     */
    public function testGetLastPartsOfDefaultDataset()
    {
        $this->controller->initActionGet();

        $this->di->get("request")->setGlobals([
            "get" => [
                "offset" => 11,
                "limit" => 2,
            ]
        ]);
        $res = $this->controller->getDataset("users");
        $json = $res[0];
        $this->assertEquals(1, count($json["data"]));
        $this->assertEquals(12, $json["data"][0]["id"]);
        $this->assertEquals(11, $json["offset"]);
        $this->assertEquals(2, $json["limit"]);
        $this->assertEquals(12, $json["total"]);
    }



    /**
     * Get new and empty dataset.
     */
    public function testGetNewDataset()
    {
        $res = $this->controller->getDataset("things");
        $this->assertInternalType("array", $res);
        $this->assertInternalType("array", $res[0]);

        $json = $res[0];
        $this->assertEquals([], $json["data"]);
        $this->assertEquals(0, $json["offset"]);
        $this->assertEquals(25, $json["limit"]);
        $this->assertEquals(0, $json["total"]);
    }



    /**
     * Get the item by id from the default dataset.
     */
    public function testGetItemFromDefaultDataset()
    {
        $this->controller->initActionGet();
        $res = $this->controller->getItem("users", 1);
        $this->assertInternalType("array", $res);
        $this->assertInternalType("array", $res[0]);

        $json = $res[0];
        $this->assertEquals(1, $json["id"]);
        $this->assertEquals("Phuong", $json["firstName"]);
        $this->assertEquals("Allison", $json["lastName"]);
    }



    /**
     * Post (add/insert) a new item to the default dataset.
     */
    public function testPostNewItem()
    {
        $this->di->get("request")->setBody('{"some": "thing"}');
        $res = $this->controller->postItem("users");
        $json = $res[0];
        $this->assertEquals(13, $json["id"]);
        $this->assertEquals("thing", $json["some"]);

        $res = $this->controller->getItem("users", 13);
        $json = $res[0];
        $this->assertEquals(13, $json["id"]);
        $this->assertEquals("thing", $json["some"]);
    }



    /**
     * Post (add/insert) a new item to new dataset.
     */
    public function testPostNewItemNewDataset()
    {
        $this->di->get("request")->setBody('{"some": "thing"}');
        $res = $this->controller->postItem("things");
        $json = $res[0];
        $this->assertEquals(1, $json["id"]);
        $this->assertEquals("thing", $json["some"]);

        $res = $this->controller->getItem("things", 1);
        $json = $res[0];
        $this->assertEquals(1, $json["id"]);
        $this->assertEquals("thing", $json["some"]);
    }



    /**
     * Put (insert/update/replace) an item to the default dataset.
     */
    public function testPutItem()
    {
        $this->controller->initActionGet();

        $this->di->get("request")->setBody('{"id": 1, "other": "thing"}');
        $res = $this->controller->putItem("users", 1);
        $json = $res[0];
        $this->assertEquals(1, $json["id"]);
        $this->assertEquals("thing", $json["other"]);

        $res = $this->controller->getItem("users", 1);
        $json = $res[0];
        $this->assertEquals(1, $json["id"]);
        $this->assertEquals("thing", $json["other"]);
    }



    /**
     * Put (insert/update/replace) an item to new dataset.
     */
    public function testPutItemNewDataset()
    {
        $this->di->get("request")->setBody('{"id": 1, "other": "thing"}');
        $res = $this->controller->putItem("things", 1);
        $json = $res[0];
        $this->assertEquals(1, $json["id"]);
        $this->assertEquals("thing", $json["other"]);

        $res = $this->controller->getItem("things", 1);
        $json = $res[0];
        $this->assertEquals(1, $json["id"]);
        $this->assertEquals("thing", $json["other"]);
    }



    /**
     * Delete an item by id from the default dataset.
     */
    public function testDeleteItemById()
    {
        $this->controller->initActionGet();

        $res = $this->controller->getItem("users", 1);
        $json = $res[0];
        $this->assertEquals(1, $json["id"]);
        $this->assertEquals("Phuong", $json["firstName"]);
        $this->assertEquals("Allison", $json["lastName"]);

        $res = $this->controller->deleteItem("users", 1);
        $json = $res[0];
        $this->assertContains("Item id '1'", $json["message"]);
        $this->assertContains("was deleted", $json["message"]);
        $this->assertContains("dataset 'users'", $json["message"]);

        $res = $this->controller->getItem("users", 1);
        $json = $res[0];
        $this->assertContains("not found", $json["message"]);
    }



    /**
     * Check the 404 route.
     */
    public function test404()
    {
        $res = $this->controller->catchAll();
        $this->assertInternalType("array", $res);
        $this->assertInternalType("array", $res[0]);

        $json = $res[0];
        $status = $res[1];
        $this->assertContains("not support", $json["message"]);
        $this->assertEquals(404, $status);

        $res = $this->controller->catchAll("some", "thing");
        $this->assertInternalType("array", $res);
        $this->assertInternalType("array", $res[0]);

        $json = $res[0];
        $status = $res[1];
        $this->assertContains("not support", $json["message"]);
        $this->assertEquals(404, $status);
    }
}
