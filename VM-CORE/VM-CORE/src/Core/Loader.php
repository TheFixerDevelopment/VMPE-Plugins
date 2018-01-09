<?php

namespace Core;

use Core\Commands\ClearInventory;
use Core\Commands\CustomPotion;
use Core\Commands\Feed;
use Core\Commands\Heal;

use Core\CustomPotion\CustomPotionEvent;
use Core\Potions\Potions;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Loader extends PluginBase implements Listener {
	
	public function onEnable() {
		
		$this->getServer()->getCommandMap()->register("clearinventory", new ClearInventory("clearinventory", $this));
		$this->getServer()->getCommandMap()->register("custompotion", new CustomPotion("custompotion", $this));
		$this->getServer()->getCommandMap()->register("feed", new Feed("feed", $this));
		$this->getServer()->getCommandMap()->register("heal", new Heal("heal", $this));

		
		$this->getServer()->getPluginManager()->registerEvents(new CustomPotionEvent($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new Potions($this), $this);
		$this->getServer()->getLogger()->notice("VMCore was enabled!");
		
	}
}	
