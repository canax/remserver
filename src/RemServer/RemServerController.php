<?php

namespace Anax\RemServer;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for the REM Server.
 */
class RemServerController implements InjectionAwareInterface
{
    use InjectionAwareTrait;



    /**
     * Initiate the REM Server.
     *
     * @return void
     */
    public function anyPrepare()
    {
        $rem = $this->di->get("rem");

        if (!$rem->hasDataset()) {
            $rem->init();
        }
    }



    /**
     * Init or re-init the REM Server.
     *
     * @return Response
     */
    public function anyInit()
    {
        $this->di->get("rem")->init();
        return $this->di->get("response")->sendJson(
            ["message" => "The session is initiated with the default dataset."]
        );
    }



    /**
     * Destroy the session to ease testing.
     *
     * @return Response
     */
    public function anyDestroy()
    {
        $this->di->get("session")->destroy();
        return $this->di->get("response")->sendJson(
            ["message" => "The session was destroyed."]
        );
    }



    /**
     * Get the dataset or parts of it.
     *
     * @param string $key for the dataset
     *
     * @return Response
     */
    public function getDataset($key)
    {
        $request = $this->di->get("request");

        $dataset = $this->di->get("rem")->getDataset($key);
        $offset  = $request->getGet("offset", 0);
        $limit   = $request->getGet("limit", 25);
        $res = [
            "data" => array_slice($dataset, $offset, $limit),
            "offset" => $offset,
            "limit" => $limit,
            "total" => count($dataset)
        ];

        return $this->di->get("response")->sendJson($res);
    }



    /**
     * Get one item from the dataset.
     *
     * @param string $key    for the dataset
     * @param string $itemId for the item to get
     *
     * @return Response
     */
    public function getItem($key, $itemId)
    {
        $response = $this->di->get("response");

        $item = $this->di->get("rem")->getItem($key, $itemId);
        if (!$item) {
            return $response->sendJson(["message" => "The item is not found."]);
        }

        return $response->sendJson($item);
    }



    /**
     * Create a new item by getting the entry from the request body and add
     * to the dataset.
     *
     * @param string $key for the dataset
     *
     * @return Response
     */
    public function postItem($key)
    {
        try {
            $entry = $this->getRequestBody();
            $item = $this->di->get("rem")->addItem($key, $entry);
        } catch (Exception $e) {
            return $this->di->get("response")->sendJson(
                ["message" => "500. HTTP request body is not an object/array or valid JSON."],
                500
            );
        }

        return $this->di->get("response")->sendJson($item);
    }


    /**
     * Upsert/replace an item in the dataset, entry is taken from request body.
     *
     * @param string $key    for the dataset
     * @param string $itemId where to save the entry
     *
     * @return void
     */
    public function putItem($key, $itemId)
    {
        try {
            $entry = $this->getRequestBody();
            $item = $this->di->get("rem")->upsertItem($key, $itemId, $entry);
        } catch (Exception $e) {
            return $this->di->get("response")->sendJson(
                ["message" => "500. HTTP request body is not an object/array or valid JSON."],
                500
            );
        }

        return $this->di->get("response")->sendJson($item);
    }



    /**
     * Delete an item from the dataset.
     *
     * @param string $key    for the dataset
     * @param string $itemId for the item to delete
     *
     * @return void
     */
    public function deleteItem($key, $itemId)
    {
        $this->di->get("rem")->deleteItem($key, $itemId);
        return $this->di->get("response")->sendJson(null);
    }



    /**
     * Show a message that the route is unsupported, a local 404.
     *
     * @return void
     */
    public function anyUnsupported()
    {
        return $this->di->get("response")->sendJson(
            ["message" => "404. The api/ does not support that."],
            404
        );
    }



    /**
     * Get the request body from the HTTP request and treat it as
     * JSON data.
     *
     * @throws Exception when request body is invalid JSON.
     *
     * @return mixed as the JSON converted content.
     */
    protected function getRequestBody()
    {
        $entry = $this->di->get("request")->getBody();
        $entry = json_decode($entry, true);

        if (is_null($entry)) {
            throw new Exception("Could not read HTTP request body as JSON.");
        }

        return $entry;
    }
}
