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
    'q' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Starship_S20.jpg/1200px-Starship_S20.jpg',
    'searchType' => 'image',
    'num' => 5,
];

$results = $service->cse->listCse($opt_params);

// Check if there are items (images) in the results
if (!isset($results['items']) || !is_array($results['items'])) die("No similar images found.\n");

// If items are found, iterate through each item and print the URLs of the similar images
foreach ($results['items'] as $item) {
    echo "Similar Image URL: " . ($item['link'] ?? 'No URL available') . "\n";
}