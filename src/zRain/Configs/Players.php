<?php


namespace zRain\Configs;


use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

use zRain\GFly;


// 玩家配置文件
class Players extends Config
{

    private $plugin;
    public function __construct(GFly $node, string $file, int $type = Config::YAML)
    {
        $this->plugin = $node;
        parent::__construct($file, $type);
        $this->setDefaults([
            "Players_Data" => []
        ]);
        $this->save();
    }
    /**
     * @description:Set up new player config   
     * @param string     
     * @return: void
     */
    public function newPlayerConfig(string $name): void
    {
        $this->setNested("Players_Data." . $name, $this->plugin->Defaultconfig->get("Each_Player_Default"));
        $this->save();
    }


    /**
     * @description: Check player's flight permission
     */
    public function checkPermission(string $player): bool
    {
        return $this->getNested("Players_Data." . $player . ".AllowFlight");
    }
}
