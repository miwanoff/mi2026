<?php

define("SIGN", "З повагою, Василь.");

$events = [
    "open_door" => "день відкритих дверей",
    "exhibition" => "відкриття виставки",
    "graduate" => "бал випускників"
];

$people = [
    "misha" => [
        "name" => "Михайло",
        "email" => "misha@mail.com"
    ],
    "arsen" => [
        "name" => "Арсеній",
        "email" => "arsen@mail.com"
    ],
    "mark" => [
        "name" => "Марк"
    ]
];

$invitation["misha"] = "open_door";
$invitation["arsen"] = "exhibition";
$invitation["mark"] = "graduate";