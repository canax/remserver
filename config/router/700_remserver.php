<?php
/**
 * Controller for the REM server.
 */
return [
    "routes" => [
        [
            "info" => "REM server with REST JSON API.",
            "mount" => "remserver",
            "handler" => "\Anax\RemServer\RemServerController",
        ],
    ]
];
