<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12.10.2017
 * Time: 14:03
 */
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://localhost:8000',
    'defaults' => [
        'exceptions' => false
    ]
]);

$name = 'Genus'.rand(0, 999);

$data = array(
    'name' => $name,
    'subFamily' => 'Octopus',
    'speciesCount' => rand(2,222),
);

$response = $client->post('/api/programmers', [
    'body' => json_encode($data)
]);

$response = $client->get('/api/programmers/'.$name);

echo $response->getBody();
echo "\n\n";