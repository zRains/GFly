<?php

namespace zRain;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
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
            $player->setFlying(true);
            if ($Join_Defaultconfig["Show_Join_Tip"]) {
                $player->sendTip($this->MSG->MSG("success", $Join_Defaultconfig["Join_Tip_Allow_Flight"]));
            }
        } else {
            $player->setAllowFlight(false);
            $player->setFlying(false);
            if ($Join_Defaultconfig["Show_Join_Tip"]) {
                $player->sendTip($this->MSG->MSG("error", $Join_Defaultconfig["Join_Tip_Not_Allow_Flight"]));
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
    public function PlayerChat(PlayerChatEvent $e)
    {
        $player = $e->getPlayer();
        $Default_Config = $this->plugin->Defaultconfig->getNested("GFly_Default");
        if ($player instanceof Player && $Default_Config["Fly_Player_Chat_Prefix"] && $player->isFlying()) {
            $e->setCancelled();
            $this->plugin->getServer()->broadcastMessage(TF::GREEN . $Default_Config["Chat_Prefix"] . TF::WHITE . " <" . $player->getName() . "> " . $e->getMessage());
        }
    }
    public function EntityDanage(EntityDamageByEntityEvent $e)
    {
        $player = $e->getEntity();
        $damager = $e->getDamager();
        if ($player instanceof Player && $damager instanceof Player) {
            if (!$player->isOp() && !$damager->isOp()) {
                if ($player->isFlying() && !$this->plugin->Player_Permission_Get($player)["Allow_Get_Damage"]) {
                    $e->setCancelled();
                    $damager->sendTip($this->MSG->MSG("error", "此玩家飞行时不受攻击"));
                }
                if ($damager->isFlying() && !$this->plugin->Player_Permission_Get($damager)["Allow_PVP"]) {
                    $e->setCancelled();
                    $damager->sendTip($this->MSG->MSG("error", "飞行特权下您不能攻击"));
                }
            }
        }
    }
}
