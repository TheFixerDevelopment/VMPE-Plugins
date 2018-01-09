<?php

namespace AAE;

use pocketmine\item\Item;

use pocketmine\Server;

use pocketmine\event\Listener;

use pocketmine\plugin\PluginBase;

use pocketmine\event\player\PlayerItemHeldEvent;

use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

	public function onLoad(){
		@mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML,array("max-level" => 9));
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getLogger()->info(TF::GREEN."Enabled!");
		if($this->getMax() === 9){
			$this->getLogger()->info(TF::GOLD."The enchantment max level is changeable in the config.yml!(/root/plugins/AntiAbusiveEnchants/config.yml)");
		}
	}

	public function onDisable(){
		$this->getLogger()->info(TF::RED."Disabled!");
	}

	public function getMax(){
		return $this->config->get("max-level");
	}

	public function onItemHeld(PlayerItemHeldEvent $ev){
		$p = $ev->getPlayer();
		$max = $this->getMax();
		$contents = $p->getInventory()->getContents();
		$i = $p->getInventory()->getItemInHand();
			if($i instanceof Item){
				if($i->hasEnchantments()){
					foreach($i->getEnchantments() as $e){
						if($e->getLevel() >= $max){
							$p->getInventory()->removeItem($i);
							$this->getServer()->getLogger()->info(TF::GREEN."[AntiAbusiveEnchants]".TF::BLUE."§cHey! You have the item ".$i->getName()."! §dIt is a bannable enchant, which is removed has been removed from §c".$p->getName()."'s §ainventory for a enchantment level over ".$this->getMax()."!");
							$p->sendMessage(TF::GREEN."[AntiAbusiveEnchants]".TF::BLUE.$i->getName()." §cHEY! You have bannable enchants! It has been removed from your inventory for being above or equal to the max enchantment level!");
						}
					}
				}
			}
		}
}
