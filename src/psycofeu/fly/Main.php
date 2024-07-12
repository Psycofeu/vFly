<?php

namespace psycofeu\fly;

use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase implements Listener
{
    use SingletonTrait;
    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->saveResource("config.yml");
        $this->saveDefaultConfig();
        $this->getLogger()->notice("Fly plugin enable | by Psycofeu");
        $this->getServer()->getCommandMap()->register("", new fly());
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function getConfigFile(): Config
    {
        return new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }
    public function teleport(EntityTeleportEvent $event)
    {
        $player = $event->getEntity();
        $enableWorld = Main::getInstance()->getConfigFile()->get("fly_world_allowed");
        if ($player instanceof Player){
            if (!Main::getInstance()->getConfigFile()->get("fly_world_mode")){
                return;
            }
            if (in_array($event->getTo()->getWorld()->getFolderName(), $enableWorld)){
                return;
            }else{
                $player->setFlying(false);
                $player->setAllowFlight(false);
            }
        }
    }
}
