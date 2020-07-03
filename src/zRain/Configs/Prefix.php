<?php

namespace zRain\Configs;

use pocketmine\utils\TextFormat as TF;

class Prefix
{
    public static $MSG = [
        "success" => TF::GREEN . "[Gfly]" . TF::WHITE,
        "error" => TF::RED . "[Gfly]" . TF::WHITE,
        "info" => TF::BLUE . "[Gfly]" . TF::WHITE
    ];
    public function MSG(string $type, string $massage = null): string
    {
        return self::$MSG[$type] . " " . $massage ?: "";
    }
}
