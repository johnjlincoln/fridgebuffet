<?php
/**
* PHP Script to handle getting data for recipes from the Food2Fork API and sending it to fridgebuffet.
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
 * @example php /path/to/apiGetNewRecipeData.php http://www.fridgebuffet.com 1337s3Kr3tAp1k3y1337
 * @var array
 */
$script_arguments = [
    'base_url'    => !empty($argv[1]) ? $argv[1] : 'localhost',
    'f2f_api_key' => !empty($argv[2]) ? $argv[2] : '',
];

// Configure cURL to request an unpulled apiRecie from the fridgebuffet apiRecipes
$defaults = [
    CURLOPT_URL            => $script_arguments['base_url'] . '/api/get/unpulledApiRecipe',
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

// Save the apiRecipe ID and corresponding Food2Fork ID
$unpulled_api_f2f_id = $response->api_f2f_id;
$unpulled_api_id = $response->api_id;

// Configure cURL for API call to Food2Fork
$params = [
    'key' => $script_arguments['f2f_api_key'],
    'rId' => $unpulled_api_f2f_id
];

$defaults = [
    CURLOPT_URL            => 'http://food2fork.com/api/get',
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
    echo 'Failed to retrieve recipe data...';
    die();
}

// Close the handle
curl_close($ch);

// Save the new recipe data
$ingredients = $response->recipe->ingredients;

// Configure cURL to send a payload of recipe data to the fridgebuffet API
$new_api_recipe_data = [
    'api_f2f_id'  => $unpulled_api_f2f_id,
    'api_id'      => $unpulled_api_id,
    'ingredients' => $ingredients
];

$payload = json_encode($new_api_recipe_data);
$http_header = [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload)
];

$defaults = [
    CURLOPT_URL            => $script_arguments['base_url'] . '/api/post/apiRecipeData',
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
