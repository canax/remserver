<?php

namespace Anax\RemServer;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A controller for the REM Server.
 */
class RemServerController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * Initiate the REM server before each action, if it has not already
     * some dataset(s).
     *
     * @return void
     */
    public function initialize() : void
    {
        $rem = $this->di->get("remserver");

        if (!$rem->hasDataset()) {
            $rem->init();
        }
    }



    /**
     * Init or re-init the REM Server.
     *
     * @return array
     */
    public function initActionGet() : array
    {
        $rem = $this->di->get("remserver");
        $rem->init();
        $json = [
            "message" => "The session is initiated with the default dataset(s).",
            "dataset" => $rem->getDefaultDataset(),
        ];
        return [$json];
    }



    /**
     * Get a dataset $key or parts of it by using the querystring.
     *
     * @param array $args variadic argument containg all parts of the
     *                    request.
     *
     * @return array
     */
    public function catchAllGet(...$args) : array
    {
        $dataSetKey = $args[0] ?? null;
        $itemId = $args[1] ?? null;
        $rest = $args[2] ?? null;

        // Type check that $itemId is int

        if ($dataSetKey && is_null($itemId)) {
            return $this->getDataset($dataSetKey);
        } elseif ($dataSetKey && !is_null($itemId) && is_null($rest)) {
            return $this->getItem($dataSetKey, $itemId);
        }

        return $this->catchAll($args);
    }



    /**
     * Get a dataset $key or parts of it by using the querystring.
     *
     * @param array $key to the dataset to get.
     *
     * @return array
     */
    public function getDataset($key) : array
    {
        $request = $this->di->get("request");
        $dataset = $this->di->get("remserver")->getDataset($key);
        $offset  = $request->getGet("offset", 0);
        $limit   = $request->getGet("limit", 25);
        $json = [
            "data" => array_slice($dataset, $offset, $limit),
            "offset" => $offset,
            "limit" => $limit,
            "total" => count($dataset)
        ];
        return [$json];
    }



    /**
     * Get one item from the dataset.
     *
     * @param string $key    for the dataset
     * @param int $itemId for the item to get
     *
     * @return array
     */
    public function getItem(string $key, int $itemId) : array
    {
        $item = $this->di->get("remserver")->getItem($key, $itemId);
        if (!$item) {
            return [["message" => "The item is not found."]];
        }
        return [$item];
    }



    /**
     * Create a new item by getting the entry from the request body and add
     * to the dataset.
     *
     * @param string $key for the dataset
     *
     * @return array
     */
    public function catchAllPost(...$args) : array
    {
        $dataSetKey = $args[0] ?? null;

        if (is_null($dataSetKey)) {
            return $this->catchAll();
        }

        try {
            $entry = $this->getRequestBody();
        } catch (Exception $e) {
            return [
                ["message" => "500. HTTP request body is not an object/array or valid JSON."],
                500
            ];
        }

        $item = $this->di->get("remserver")->addItem($dataSetKey, $entry);
        return [$item];
    }


    /**
     * Upsert/replace an item in the dataset, entry is taken from request body.
     *
     * @param string $key    for the dataset
     * @param string $itemId where to save the entry
     *
     * @return void
     */
    public function catchAllPut(...$args) : array
    {
        $dataSetKey = $args[0] ?? null;
        $itemId = $args[1] ?? null;

        if (!($dataSetKey && !is_null($itemId))) {
            return $this->catchAll($args);
        }

        // This should be managed through the typed route
        $itemId = intval($itemId);

        try {
            $entry = $this->getRequestBody();
        } catch (Exception $e) {
            return [
                ["message" => "500. HTTP request body is not an object/array or valid JSON."],
                500
            ];
        }

        $item = $this->di->get("remserver")->upsertItem($dataSetKey, $itemId, $entry);
        return [$item];
    }



    /**
     * Delete an item from the dataset.
     *
     * @param string $key    for the dataset
     * @param string $itemId for the item to delete
     *
     * @return array
     */
    public function catchAllDelete(...$args) : array
    {
        $dataSetKey = $args[0] ?? null;
        $itemId = $args[1] ?? null;

        if (!($dataSetKey && !is_null($itemId))
            || count($args) != 2
            || !(is_int($itemId) || ctype_digit($itemId))
        ) {
            return $this->catchAll($args);
        }

        // This should be managed through the typed route
        $itemId = intval($itemId);

        $this->di->get("remserver")->deleteItem($dataSetKey, $itemId);
        $json = [
            "message" => "Item id '$itemId' was deleted from dataset '$dataSetKey'.",
        ];
        return [$json];
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



    /**
     * Show a message that the route is unsupported, a local 404.
     *
     * @return void
     */
    public function catchAll()
    {
        return [["message" => "404. The api does not support that."], 404];
    }
}
