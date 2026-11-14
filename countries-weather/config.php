<?php
$envPath = __DIR__ . '/.env';


if (! is_file($envPath) || ! is_readable($envPath)) {
    throw new RuntimeException('.env file is missing or unreadable.');
}
$config = parse_ini_file(
    $envPath,
    false,
    INI_SCANNER_RAW
);


if ($config === false) {
    throw new RuntimeException('Cannot read .env file.');
}


$apiKey = trim($config['WEATHER_API_KEY'] ?? '');


if ($apiKey === '') {
    throw new RuntimeException('Weather API key is not configured.');
}
return [
    'weather_api_key' => $apiKey,
];