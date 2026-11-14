<?php
function getCapitalWeather(string $capital): ?array 
{
    $config = require __DIR__ . '/config.php'; 
    
    $url = 'https://api.openweathermap.org/data/2.5/weather?' .
    http_build_query([
        'q'     => $capital, 
        'lang'  => 'uk', 
        'units' => 'metric', 
        'APPID' => $config['weather_api_key'], 
    ]); 
    
    $response = file_get_contents($url);
    
    if ($response === false) {
        return null;
    }
    
    $data = json_decode($response, true);
    
    if (! isset($data['main'], $data['weather'][0])) {
        return null;
    }
    
    return [
        'city'        => $data['name'], 
        'country'     => $data['sys']['country'], 
        'temperature' => $data['main']['temp'], 
        'condition'   => $data['weather'][0]['description'], 
        'humidity'    => $data['main']['humidity'], 
        'wind'        => $data['wind']['speed'], 
        'updated'     => date('Y-m-d H:i:s', $data['dt']), 
    ];
}