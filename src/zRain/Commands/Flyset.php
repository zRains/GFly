<?php


namespace zRain\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

use zRain\GFly;
use zRain\Configs\Prefix;


class Flyset extends Command
{
    #GFlyplugin
    private $plugin;
    #Plugin prefix
    private $MSG;
    public function __construct(GFly $node)
    {
        parent::__construct("gfly", "给玩家体验一下飞行", "\n使用方法\n" . TF::BLUE . "管理员：/gfly s [af/ab/gd/pvp] true/false <player(s)> =>设置玩家相关飞行权限\n" . TF::GREEN . "玩家：/gfly t =>开启飞行", []);
        $this->plugin = $node;
        $this->MSG = new Prefix;
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (count($args) === 0) {
            $sender->sendMessage($this->MSG->MSG("error", TF::RED . $this->getUsage()));
            return false;
        }
        switch ($args[0]) {
            case 's':
                if (!$sender->isOp()) {
                    $sender->sendMessage($this->MSG->MSG("error", TF::RED . "你不是管理员"));
                    return false;
                }
                if (count($args) > 2 && array_key_exists($args[1], $this->plugin->CommandMap) && ($args[2] === "true" || $args[2] === "false")) {
                    if (!array_key_exists($args[1], $this->plugin->CommandMap)) {
                        $sender->sendMessage($this->MSG->MSG("error", $this->getUsage()));
                        return false;
                    }
                    $playerList = $this->plugin->Player_Permission_Set(array_slice($args, 3), $args[1], $args[2] === "true" ?: false);
                    $sender->sendMessage(TF::BOLD . TF::GREEN . "------处理结果------");
                    $sender->sendMessage(implode(" | ", $playerList));
                } else {
                    $sender->sendMessage($this->MSG->MSG("error", TF::RED . $this->getUsage()));
                }
                break;
            case 't':
                if (!$sender instanceof Player) {
                    $sender->sendMessage($this->MSG->MSG("error", TF::RED . "请在游戏内使用"));
                    return false;
                }
                if ($this->plugin->Player_Permission_Get($sender)["AllowFlight"]) {
                    $sender->setAllowFlight(true);
                    $sender->sendTip($this->MSG->MSG("info", TF::BLUE . "你现在可以飞行了"));
                } else {
                    $sender->sendTip($this->MSG->MSG("error", TF::RED . "你还没有飞行权限"));
                }
                break;
            case 'i':
                if ($sender instanceof Player) {
                    $Player_GFly_Permissions = $this->plugin->Player_Permission_Get($sender);
                    foreach ($Player_GFly_Permissions as $key => $value) {
                        $sender->sendMessage($this->MSG->MSG("info", $key . ": " . ($value ? TF::BLUE . "开启" : TF::RED . "禁用")));
                    }
                } else {
                    $sender->sendMessage("请在游戏内使用");
                }
                break;
            default:
                break;
        }
    }
}
