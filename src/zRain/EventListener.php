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
        $Join_Defaultconfig = $this->plugin->Defaultconfig->getNested("GFly_Default");
        if ($Join_Defaultconfig["Auto_Player_Config"] && !array_key_exists($player->getName(), $this->plugin->config->get("Players_Data"))) {
            $this->plugin->config->newPlayerConfig($player->getName());
        }
        if ($Join_Defaultconfig["Auto_In_fly"]  && $this->plugin->Player_Permission_Get($player)["AllowFlight"]) {
            $player->setAllowFlight(true);
            if ($Join_Defaultconfig["Show_Join_Tip"]) {
                $player->sendTip($this->MSG->MSG("success", $Join_Defaultconfig["Join_Tip_Allow_Flight"]));
            }
        } else {
            $player->setAllowFlight(false);
            if ($Join_Defaultconfig["Show_Join_Tip"]) {
                $player->sendTip($this->MSG->MSG("success", $Join_Defaultconfig["Join_Tip_Not_Allow_Flight"]));
            }
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
