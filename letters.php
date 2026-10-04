<?php
require("invitation.php");

foreach ($people as $key => $man_info) {
    $event_key = $invitation[$key];
    if ($event_key != "") {
        foreach ($man_info as $key1 => $info) {
            if ($key1 == "name")
                $str = "Шановний $info!";
            if ($key1 == "email")
                $email = $info;
        }
        $str .= "\nЗапрошуємо Вас на " .
                $events[$event_key];
        switch ($event_key) {
            case "open_door":
                $str .= "\nПідтвердьте Вашу участь за телефоном!";
                break;
            case "exhibition":
                $str .= "\nПриходьте за 15 хвилин до відкриття!";
                break;
            case "graduate":
                $str .= "\nНе забудьте подарунок :-)";
                break;
            default: $str .= "\nВибачте, але Вас поки що нікуди не запрошують...";
        }
        $str .= "\n" . SIGN . "\n";

        echo $str;
    }
}