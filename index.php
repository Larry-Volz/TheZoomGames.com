<?php
namespace think;

require __DIR__ . '/zoom/vendor/autoload.php';

$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);
