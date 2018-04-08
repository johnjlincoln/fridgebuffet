<?php
/**
* PHP Script to handle getting recipe specific data from the Food2Fork API.
*
* @author John J Lincoln <jlincoln88@gmail.com>
* @copyright 2018 Arctic Pangolin
*/

$params = [
    'url' => !empty($argv[1]) ? $argv[1] : 'localhost/api/get/recipeData'
];

// Configure cURL
$defaults = [
    CURLOPT_URL => $params['url']
];
$ch = curl_init();
curl_setopt_array($ch, $defaults);

// Send request
curl_exec($ch);

// Check for errors and display the error message
// TODO: logger? console print? pass up to cron? Not this though
if ($errno = curl_errno($ch)) {
    $error_message = curl_strerror($errno);
    echo "cURL error ({$errno}):\n {$error_message}";
}

// Close the handle and die.
curl_close($ch);
die();
