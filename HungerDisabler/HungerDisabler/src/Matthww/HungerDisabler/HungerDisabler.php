<?php

namespace Matthww\HungerDisabler;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\plugin\PluginBase;

class HungerDisabler extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->notice("is enabled");
    }

    public function onDisable() {
        $this->getLogger()->notice("is disabled!");
    }

    public function Hunger(PlayerExhaustEvent $exhaustEvent) {
        $exhaustEvent->setCancelled(true);
    }
}
