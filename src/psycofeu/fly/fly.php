<?php

namespace psycofeu\fly;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class fly extends Command
{
    public function __construct()
    {
        parent::__construct("fly", Main::getInstance()->getConfigFile()->get("fly_description"), "/fly");
        $this->setPermission("fly.use");
        $this->setPermissionMessage(Main::getInstance()->getConfigFile()->get("fly_no_perm"));
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!$sender instanceof Player) return;
        $enableWorld = Main::getInstance()->getConfigFile()->get("fly_world_allowed");
        if (!Main::getInstance()->getConfigFile()->get("fly_world_mode")){
            $this->fly($sender);
            return;
        }
        if (in_array($sender->getWorld()->getFolderName(), $enableWorld)){
            $this->fly($sender);
        }else{
            $sender->sendMessage(Main::getInstance()->getConfigFile()->get("cant_fly_on_this_world"));
        }
    }
    public function fly(Player $player): void
    {
        if ($player->getAllowFlight()){
            $player->setAllowFlight(false);
            $player->setFlying(false);
            $player->sendMessage(Main::getInstance()->getConfigFile()->get("disable_fly"));
        }else{
            $player->setAllowFlight(true);
            $player->sendMessage(Main::getInstance()->getConfigFile()->get("enable_fly"));
        }
    }
}