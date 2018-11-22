<?php

namespace Anax\RemServer;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test for RemServerController to stress failure.
 */
class RemServerControllerUsageFailTest extends TestCase
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
     * Get item that does not exists.
     */
    public function testGetItemDoesNotExists()
    {
        $res = $this->controller->catchAllGet("things", 1);

        $json = $res[0];
        $this->assertContains("not found", $json["message"]);
    }



    /**
     * Create a new item with bad json (not array) in request body.
     */
    public function testPostItemJsonNotArray()
    {
        $this->di->get("request")->setBody("'bad json'");
        $res = $this->controller->catchAllPost("users");

        $json = $res[0];
        $status = $res[1];
        $this->assertContains("not an object/array", $json["message"]);
        $this->assertEquals(500, $status);
    }



    /**
     * Create a new item with bad json in request body.
     */
    public function testPostItemBadJson()
    {
        $this->di->get("request")->setBody("{ bad json }");
        $res = $this->controller->catchAllPost("users");

        $json = $res[0];
        $status = $res[1];
        $this->assertContains("valid JSON", $json["message"]);
        $this->assertEquals(500, $status);
    }
    
    
    
    /**
     * Update a item with bad json (not array) in request body.
     */
    public function testPutItemJsonNotArray()
    {
        $this->di->get("request")->setBody("bad json");
        $res = $this->controller->catchAllPut("users", 1);

        $json = $res[0];
        $status = $res[1];
        $this->assertContains("not an object/array", $json["message"]);
        $this->assertEquals(500, $status);
    }



    /**
     * Update a item with bad json in request body.
     */
    public function testPutItemBadJson()
    {
        $this->di->get("request")->setBody("{ bad json }");
        $res = $this->controller->catchAllPut("users", 1);

        $json = $res[0];
        $status = $res[1];
        $this->assertContains("valid JSON", $json["message"]);
        $this->assertEquals(500, $status);
    }


    /**
     * Delete an item when dataset does not exists.
     */
    public function testDeleteItemWhenDatasetNotExists()
    {
        $res = $this->controller->catchAllDelete("users", 99);
        
        $json = $res[0];
        $this->assertContains("Item id '99'", $json["message"]);
        $this->assertContains("was deleted", $json["message"]);
        $this->assertContains("dataset 'users'", $json["message"]);
    }



    /**
     * Delete an item that does not exists.
     */
    public function testDeleteItemNotExists()
    {
        $this->controller->initActionGet();
        $res = $this->controller->catchAllDelete("users", 99);

        $json = $res[0];
        $this->assertContains("Item id '99'", $json["message"]);
        $this->assertContains("was deleted", $json["message"]);
        $this->assertContains("dataset 'users'", $json["message"]);
    }



    /**
     * Delete an item without specifying a numeric key.
     */
    public function testDeleteItemKeyNotNumeric()
    {
        $res = $this->controller->catchAllDelete("users", "no-key");
        $json = $res[0];
        $status = $res[1];
        $this->assertContains("not support", $json["message"]);
        $this->assertEquals(404, $status);
    }



    /**
     * Delete an item with two many arguments.
     */
    public function testDeleteToManyArguments()
    {
        $res = $this->controller->catchAllDelete("users", 1, 1);
        $json = $res[0];
        $status = $res[1];
        $this->assertContains("not support", $json["message"]);
        $this->assertEquals(404, $status);
    }
}
