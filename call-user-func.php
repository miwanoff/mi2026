<?php

// function order($item)
//  {
//      echo "Ви замовили чашку $item - будь ласка!\n";
//  }
//  call_user_func('order', "чаю");
//  call_user_func('order', "какао");

function discount1($price) {
    return $price - 20;
}

function discount2($price) {
    return $price / 2;
}

function getPrice($discount = null) {
    $price = 100;
    if (isset($discount))
        $price = call_user_func($discount, $price);
    return $price;
}


echo getPrice("discount1")."\n";
echo getPrice("discount2")."\n";
echo getPrice()."\n";