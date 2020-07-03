<?php

namespace zRain;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;


use zRain\GFly;
use zRain\Configs\Prefix;

class EventListener implements Listener
{
    private $plugin;
    private $MSG;
    public function __construct(GFly $target)
    {
        $this->plugin = $target;
        $this->MSG = new Prefix;
    }
    public function PlayerJoin(PlayerJoinEvent $e)
    {
        $player = $e->getPlayer();
        $Auto_Player_Config = $this->plugin->Defaultconfig->getNested("GFly_Default.Auto_Player_Config");
        if ($Auto_Player_Config && !array_key_exists($player->getName(), $this->plugin->config->get("Players_Data"))) {
            $this->plugin->config->newPlayerConfig($player->getName());
        }
    }
    public function PlayerBreakBlocks(BlockBreakEvent $e)
    {
        $player = $e->getPlayer();
        if ($player instanceof Player && !$this->plugin->Player_Permission_Get($player, "ab") && $player->isFlying()) {
            $e->setCancelled();
            $player->sendTip($this->MSG->MSG("error", "你在飞行时不能进行破环"));
        }
    }
}
