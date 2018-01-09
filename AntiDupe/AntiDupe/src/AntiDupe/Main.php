<?php
   

namespace AntiDupe;

use pocketmine\tile\Tile;
use pocketmine\tile\Hopper;
use pocketmine\event\Listener as LT;
use pocketmine\plugin\PluginBase as PB;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;

class Main extends PB implements LT{
	
	public $prefix = "§8[§5AntiDupe§8] ";
	
	
	public function onEnable(){
		
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onTap(PlayerInteractEvent $e){
		
		$p = $e->getPlayer();
		$b = $e->getBlock();
		$i = $p->getInventory()->getItemInHand();
		$tile = $p->getLevel()->getTile($b);
		
		if($b->getId() == 145){
			$e->setCancelled(true);
			
			if($i->getId() == 0){
			
				$p->sendPopup("§cPut an item in your hand");
				
				return true;
				
			}
			
			$id = $i->getId();
			if($id == 256 || $id == 257|| $id == 258 || $id == 259 || $id == 267 || $id == 276 || $id == 277 || $id == 278 || $id == 279 || $id == 306 || $id == 307 || $id == 308 || $id == 309 || $id == 310 || $id == 311 || $id == 312 || $id == 313 || $id == 292 || $id == 293){
				
				if($p->getXpLevel() < 30){
					$p->sendPopup("§cInsufficient Xp.");
					return true;
				}
				
				if($i->getDamage() == 0){
				
					$p->sendPopup("§cThis item is already repaired.");
					return true;
				}
				
				$p->setXpLevel($p->getXpLevel() -30);
				$i->setDamage(0);
				$p->getInventory()->setItemInHand($i);
				$p->getLevel()->addSound(new AnvilUseSound($p));
				$p->sendMessage("§cItem successfully repaired.");
				$p->sendPopup("§cItem successfully repaired.");
				return true;
			}
			
			$p->sendPopup("§cThis item is not repairable."); 
			return true;
		}
		
		if($tile instanceof Hopper){
			$e->setCancelled(true);
			return true;
		}
		
		if($i->getId() == 410){
			$e->setCancelled(true);
			return true;
		}
	}
}
