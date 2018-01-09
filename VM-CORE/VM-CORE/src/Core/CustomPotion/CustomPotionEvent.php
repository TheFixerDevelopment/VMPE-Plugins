<?php

namespace Core\CustomPotion;

use Core\Loader;

use pocketmine\entity\Effect;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class CustomPotionEvent implements Listener {
	
	public function onConsume(PlayerItemConsumeEvent $event) {
		
		$player = $event->getPlayer();
		
		if($event->getItem()->getId() === 373) {
		
			$damage = $event->getItem()->getDamage();
			
			switch($damage) {
				
				case 100:
				
				$player->addEffect(Effect::getEffect(Effect::SPEED)->setDuration(360*20)->setAmplifier(1));
				$player->addEffect(Effect::getEffect(Effect::HASTE)->setDuration(360*20)->setAmplifier(2));
				$player->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setDuration(180*20)->setAmplifier(1));
				
				$player->getInventory()->removeItem(Item::get(Item::POTION, 100, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				$player->addTitle(TF::DARK_GRAY . TF::BOLD . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "Consumed:", TF::RED . TF::BOLD . "Raiding Elixir");
				return true;
				break;
				
				case 101:
				
				$player->addEffect(Effect::getEffect(Effect::JUMP)->setDuration(180*20)->setAmplifier(1));
				$player->addEffect(Effect::getEffect(Effect::STRENGTH)->setDuration(30*20)->setAmplifier(1));
				$player->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setDuration(360*20)->setAmplifier(1));
				$player->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(360*20)->setAmplifier(1));
				
				$player->getInventory()->removeItem(Item::get(Item::POTION, 101, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				$player->addTitle(TF::DARK_GRAY . TF::BOLD . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "Consumed:", TF::AQUA . TF::BOLD . "PVP Elixir");
				return true;
				break;
				
			}
		}
	}
	
	public function onHeld(PlayerItemHeldEvent $event) {
		
		$player = $event->getPlayer();
		
		if($event->getItem()->getId() === 373) {
			
			$damage = $event->getItem()->getDamage();
			$hand = $player->getInventory()->getItemInHand();
			
			switch($damage) {
				
				case 100:
				
				$item = Item::get(Item::POTION, 100, 1);
				
				$player->getInventory()->removeItem($item);
				
				$item->setCustomName(TF::RESET . TF::RED . TF::BOLD . "Raiding Elixir" . PHP_EOL . PHP_EOL .
									 TF::RESET . TF::DARK_GRAY . " * " . TF::GREEN . "Speed I" . TF::GRAY . " (6:00)" . PHP_EOL .
									 TF::DARK_GRAY . " * " . TF::GREEN . "Haste II" . TF::GRAY . " (6:00)" . PHP_EOL .
									 TF::DARK_GRAY . " * " . TF::GREEN . "Night Vision" . TF::GRAY . " (3:00)");
				
				$player->getInventory()->addItem($item);
				return true;
				
				break;
				
				case 101:
				
				$item = Item::get(Item::POTION, 101, 1);
				
				$player->getInventory()->removeItem($item);
				
				$item->setCustomName(TF::RESET . TF::AQUA . TF::BOLD . "PVP Elixir" . PHP_EOL . PHP_EOL .
									 TF::RESET . TF::DARK_GRAY . " * " . TF::GREEN . "Jump Boost I" . TF::GRAY . " (3:00)" . PHP_EOL .
									 TF::DARK_GRAY . " * " . TF::GREEN . "Strength I" . TF::GRAY . " (0:30)" . PHP_EOL .
									 TF::DARK_GRAY . " * " . TF::GREEN . "Night Vision" . TF::GRAY . " (6:00)" . PHP_EOL .
									 TF::DARK_GRAY . " * " . TF::GREEN . "Fire Resistance" . TF::GRAY . " (6:00)");
									 
				$player->getInventory()->addItem($item);
				return true;
				break;
		
			}
			
			if($hand->hasCustomName()) {
				
				$event->setCancelled();
				
			}
		}
	}
}
