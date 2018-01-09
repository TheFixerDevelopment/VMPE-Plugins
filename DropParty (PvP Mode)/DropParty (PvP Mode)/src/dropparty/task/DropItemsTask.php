<?php

namespace dropparty\task;

use pocketmine\scheduler\PluginTask;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use dropparty\DropParty;

class DropItemsTask extends PluginTask {
	
	public function __construct(DropParty $plugin) {
		parent::__construct($plugin);
		$this->plugin = $plugin;	
	}
	
	public function getPlugin() {
		return $this->plugin;
	}
	
	public function onRun(int $currentTick) {
		
		if($this->getPlugin()->status == "enabled") {
		  $level = $this->getPlugin()->getServer()->getLevelByName($this->getPlugin()->cfg["World"]);
			
		  foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $p) {
		    if($this->getPlugin()->config()["Popup.Enabled"] == true) {
		      $p->sendPopup($this->getPlugin()->config()["Popup.Message"]);
		     }
		    }
			$this->getPlugin()->secs++;
			
			if($level !== null) {
			  $level->dropItem(new Vector3($this->getPlugin()->cfg["Coordinates"]["X"], $this->getPlugin()->cfg["Coordinates"]["Y"], $this->getPlugin()->cfg["Coordinates"]["Z"]), Item::get($this->getPlugin()->getRandomItem(), 0, mt_rand(1, 5)));
			} else {
			  $this->getPlugin()->getLogger()->warning("§cItems could not be dropped. World doesn't exist.");
			}
		}
		
	    if($this->getPlugin()->secs == $this->getPlugin()->config()["Duration"]) {			
	      if($this->getPlugin()->status == "enabled") {
		$this->getPlugin()->getServer()->broadcastMessage($this->getPlugin()->config()["Message.Ended"]);
		$this->getPlugin()->status = "ended";
		$this->getPlugin()->secs = 0;				
		$this->getPlugin()->time = $this->getPlugin()->cfg["Time"];
	       }
	    }
	}
		
}
