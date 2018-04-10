<?php
/**
* PHP Script to handle getting new recipes from the Food2Fork API and sending them to fridgebuffet.
*
* @author John J Lincoln <jlincoln88@gmail.com>
* @copyright 2018 Arctic Pangolin
*/

/**
 * Script Arguments
 * These MUST be passed in when executing this script to ensure functionality
 *
 * Argument 1 - Base URL of the application
 * Argument 2 - F2F API Key
 *
 * @example php /path/to/apiGetNewRecipes.php http://www.fridgebuffet.com 1234s3Kr3tAp1k3y1234
 * @var array
 */
$script_arguments = [
    'base_url'    => !empty($argv[1]) ? $argv[1] : 'localhost',
    'f2f_api_key' => !empty($argv[2]) ? $argv[2] : '',
];

// Configure cURL to request page info from the fridgebuffet API
$defaults = [
    CURLOPT_URL            => $script_arguments['base_url'] . '/api/get/pageInfo',
    CURLOPT_RETURNTRANSFER => true
];

$ch = curl_init();
curl_setopt_array($ch, $defaults);

// Send request and load response
$response = curl_exec($ch);
$response = json_decode($response);

// Check for errors and display the error message - die if error
if ($errno = curl_errno($ch)) {
    $error_message = curl_strerror($errno);
    echo "cURL error ({$errno}):\n {$error_message}";
    die();
}

// Close the handle
curl_close($ch);

// Save the page number of the next page of recipes to request from Food2Fork
$page = $response->next_page ?? $response->current_page;

// Configure cURL for API call to Food2Fork
$params = [
    'key'  => $script_arguments['f2f_api_key'],
    'page' => $page
];

$defaults = [
    CURLOPT_URL            => 'http://food2fork.com/api/search',
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $params,
    CURLOPT_RETURNTRANSFER => true
];

$ch = curl_init();
curl_setopt_array($ch, $defaults);

// Send request and load response
$response = curl_exec($ch);
$response = json_decode($response);

// Check for errors and display the error message - die if error
if ($errno = curl_errno($ch)) {
    $error_message = curl_strerror($errno);
    echo "cURL error ({$errno}):\n {$error_message}";
    die();
}

if (!isset($response)) {
    echo 'Failed to retrieve new recipes...';
    die();
}

// Close the handle
curl_close($ch);

// Save the new recipes as well as the count of new recipes
$new_recipes = $response->recipes;
$new_recipes_count = $response->count;

// Configure cURL to send a payload of new recipes to the fridgebuffet API
$new_api_recipes = [
    'page'              => $page,
    'new_recipes'       => $new_recipes,
    'new_recipes_count' => $new_recipes_count
];

$payload = json_encode($new_api_recipes);
$http_header = [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload)
];

$defaults = [
    CURLOPT_URL            => $script_arguments['base_url'] . '/api/post/apiRecipes',
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => $http_header
];

$ch = curl_init();
curl_setopt_array($ch, $defaults);

// Send request and load response
$response = curl_exec($ch);

// Check for errors and display the error message - die if error
if ($errno = curl_errno($ch)) {
    $error_message = curl_strerror($errno);
    return response()->json([
        'error' => "cURL error ({$errno}):\n {$error_message}"
        ]);
    die();
}

// Echo the json response of the fridgebuffet endpoint
echo $response;

// Close the handle and die
curl_close($ch);
die();
