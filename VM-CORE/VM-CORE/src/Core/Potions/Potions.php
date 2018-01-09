<?php

namespace Core\Potions;

use Core\Loader;

use pocketmine\entity\Effect;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Potions implements Listener {
	
	public function onConsume(PlayerItemConsumeEvent $event) {
		
		$player = $event->getPlayer();
		
		if($event->getItem()->getId() === 373) {
		
			$damage = $event->getItem()->getDamage();
			
			switch($damage) {
				
				case 5:
				
				$player->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setDuration(180*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 5, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				
				break;
				
				case 6:
				
				$player->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setDuration(480*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 6, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				
				break;
				
				case 7:
				
				$player->addEffect(Effect::getEffect(Effect::INVISIBILITY)->setDuration(180*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 7, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				
				break;
				
				case 8:
				
				$player->addEffect(Effect::getEffect(Effect::INVISIBILITY)->setDuration(480*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 8, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				
				break;
				
				case 9:
				
				$player->addEffect(Effect::getEffect(Effect::JUMP)->setDuration(180*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 9, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				
				break;
				
				case 10:
				
				$player->addEffect(Effect::getEffect(Effect::JUMP)->setDuration(480*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 10, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 11:
				
				$player->addEffect(Effect::getEffect(Effect::JUMP)->setDuration(90*20)->setAmplifier(2));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 11, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 12:
				
				$player->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(180*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 12, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 13:
				
				$player->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(480*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 13, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 14:
				
				$player->addEffect(Effect::getEffect(Effect::SPEED)->setDuration(180*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 14, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 15:
				
				$player->addEffect(Effect::getEffect(Effect::SPEED)->setDuration(480*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 15, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 16:
				
				$player->addEffect(Effect::getEffect(Effect::SPEED)->setDuration(90*20)->setAmplifier(2));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 16, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 17:
				
				$player->addEffect(Effect::getEffect(Effect::SLOWNESS)->setDuration(90*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 17, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 18:
				
				$player->addEffect(Effect::getEffect(Effect::SLOWNESS)->setDuration(240*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 18, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 19:
				
				$player->addEffect(Effect::getEffect(Effect::WATER_BREATHING)->setDuration(180*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 19, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 20:
				
				$player->addEffect(Effect::getEffect(Effect::WATER_BREATHING)->setDuration(480*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 20, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 21:
				
				$player->addEffect(Effect::getEffect(Effect::INSTANT_HEALTH)->setDuration(1)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 21, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 22:
				
				$player->addEffect(Effect::getEffect(Effect::INSTANT_HEALTH)->setDuration(1)->setAmplifier(2));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 22, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 23:
				
				$player->addEffect(Effect::getEffect(Effect::INSTANT_DAMAGE)->setDuration(1)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 23, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 24:
				
				$player->addEffect(Effect::getEffect(Effect::INSTANT_DAMAGE)->setDuration(1)->setAmplifier(2));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 24, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 25:
				
				$player->addEffect(Effect::getEffect(Effect::POISON)->setDuration(45*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 25, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 26:
				
				$player->addEffect(Effect::getEffect(Effect::POISON)->setDuration(120*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 26, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 27:
				
				$player->addEffect(Effect::getEffect(Effect::POISON)->setDuration(22*20)->setAmplifier(2));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 27, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 28:
				
				$player->addEffect(Effect::getEffect(Effect::REGENERATION)->setDuration(45*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 28, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 29:
				
				$player->addEffect(Effect::getEffect(Effect::REGENERATION)->setDuration(120*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 29, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 30:
				
				$player->addEffect(Effect::getEffect(Effect::REGENERATION)->setDuration(22*20)->setAmplifier(2));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 30, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 31:
				
				$player->addEffect(Effect::getEffect(Effect::STRENGTH)->setDuration(180*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 31, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 32:
				
				$player->addEffect(Effect::getEffect(Effect::STRENGTH)->setDuration(480*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 32, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 33:
				
				$player->addEffect(Effect::getEffect(Effect::STRENGTH)->setDuration(90*20)->setAmplifier(2));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 33, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 34:
				
				$player->addEffect(Effect::getEffect(Effect::WEAKNESS)->setDuration(90*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 34, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 35:
				
				$player->addEffect(Effect::getEffect(Effect::WEAKNESS)->setDuration(240*20)->setAmplifier(1));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 35, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
				case 36:
				
				$player->addEffect(Effect::getEffect(Effect::WITHER)->setDuration(40*20)->setAmplifier(2));
				$player->getInventory()->removeItem(Item::get(Item::POTION, 36, 1));
				$player->getInventory()->addItem(Item::get(Item::GLASS_BOTTLE, 0, 1));
				return true;
				break;
				
			}
		}
	}
}
