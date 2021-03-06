<?php

namespace zRain;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

use zRain\EventListener;
use zRain\Configs\Players;
use zRain\Commands\Flyset;

class GFly extends PluginBase
{
    public $config;
    public $Defaultconfig;
    # Aliases for the son commands
    public $CommandMap = [
        "af" => "AllowFlight",
        "ab" => "Allow_Break_Blocks",
        "gd" => "Allow_Get_Damage",
        "pvp" => "Allow_PVP"
    ];
    public function onEnable()
    {
        $commandMaps = $this->getServer()->getCommandMap();
        $this->saveResource("Default.yml");
        $this->Defaultconfig = new Config($this->getDataFolder() . "Default.yml", Config::YAML);
        $this->config = new Players($this, $this->getDataFolder() . "Players.yml");
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        foreach ([
            "flyset" => new Flyset($this),
        ] as $index => $command) {
            $commandMaps->register("gfly", $command);
        }
        $this->getLogger()->info(Tf::BLUE . TF::BOLD . "插件已启用 | version: 1.0.0 | author: zRain");
    }
    /**
     * @description: Allow players to fly
     */
    public function Player_Permission_Set(array $players, string $mode, bool $stats): array
    {
        $playerData = $this->config->getNested("Players_Data");
        $playerList = [];
        foreach ($players as $name) {
            if (array_key_exists($name, $playerData)) {
                $this->config->setNested("Players_Data." . $name . "." . $this->CommandMap[$mode], $stats);
                array_push($playerList, TF::GREEN . $name . TF::WHITE);
            } else {
                $this->config->newPlayerConfig($name);
                $this->config->setNested("Players_Data." . $name . "." . $this->CommandMap[$mode], $stats);
                array_push($playerList, TF::AQUA . $name . TF::WHITE);
            }
        }
        $this->config->save();
        return $playerList;
    }
    /**
     * @description: Return player's flight permission
     */
    public function Player_Permission_Get(Player $player): array
    {
        $Data = $this->config->getNested("Players_Data." . $player->getName());
        if (!$Data) {
            return $this->Defaultconfig->getNested("Each_Player_Default");
        } else {
            return $Data;
        }
    }
    /**
     * @description: PLugin disable
     */
    public function onDisable()
    {
        $this->getLogger()->info(Tf::RED . "插件已关闭");
        $this->config->save();
    }
}
