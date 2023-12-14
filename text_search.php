<?php

// composer require symfony/dotenv google/apiclient
require_once 'vendor/autoload.php';

// load environmental variables
$dotenv = new \Symfony\Component\Dotenv\Dotenv(true);
$dotenv->load(__DIR__ . '/.env');

$client = new Google\Client();

// https://developers.google.com/custom-search/v1/introduction
$client->setApplicationName($_ENV['APP_NAME']);
$client->setDeveloperKey($_ENV['API_KEY']);

$service = new Google\Service\CustomSearchAPI($client);

// https://developers.google.com/custom-search/v1/reference/rest/v1/cse/list
$opt_params = [
    'cx' => $_ENV['CSE_ID'], // https://programmablesearchengine.google.com/controlpanel/all
    'q' => 'Kawasaki ZX-10R',
    'num' => 5,
];

$results = $service->cse->listCse($opt_params);

foreach (($results['items'] ?? []) as $item) {
    echo ($item['title'] ?? 'No title available') . "\n";
    echo ($item['link'] ?? 'No URL available') . "\n";
    echo ($item['snippet'] ?? 'No description available') . "\n---\n";
}