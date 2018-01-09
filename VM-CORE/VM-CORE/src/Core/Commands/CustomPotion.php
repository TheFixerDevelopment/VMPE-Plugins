<?php

namespace Core\Commands;

use Core\Loader;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\entity\Effect;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class CustomPotion extends PluginCommand {
	
	private $main;

    public function __construct($name, Loader $main) {
		
        parent::__construct($name, $main);
        $this->main = $main;
		
    }
	
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		
		if($sender->hasPermission("vmcore.command.cp") || $sender->isOp()){
				
			if(isset($args[0])) {
					 
				$player = $sender->getServer()->getPlayer($args[0]);
				$name = $player->getName();
					 
				if(isset($args[1])) {
						 
					switch($args[1]) {
							 
						case "raiding":
							 
						$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You have given " . $name . " a " . TF::RED . TF::BOLD . "Raiding Elixir" . TF::RESET . TF::GRAY . ".");
							 
						$raiding = Item::get(Item::POTION, 100, 1);
						$raiding->setCustomName(TF::RESET . TF::RED . TF::BOLD . "Raiding Elixir" . PHP_EOL . PHP_EOL .
												TF::RESET . TF::DARK_GRAY . " * " . TF::GREEN . "Speed I" . TF::GRAY . " (6:00)" . PHP_EOL .
												TF::DARK_GRAY . " * " . TF::GREEN . "Haste II" . TF::GRAY . " (6:00)" . PHP_EOL .
												TF::DARK_GRAY . " * " . TF::GREEN . "Night Vision" . TF::GRAY . " (3:00)");
													 
						$player->getInventory()->addItem($raiding);
						return true;
							 
						break;
							 
						case "pvp":
							 
						$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You have given " . $name . " a " . TF::AQUA . TF::BOLD . "PVP Elixir" . TF::RESET . TF::GRAY . ".");
							 
						$pvp = Item::get(Item::POTION, 101, 1);
						$pvp->setCustomName(TF::RESET . TF::AQUA . TF::BOLD . "PVP Elixir" . PHP_EOL . PHP_EOL .
											TF::RESET . TF::DARK_GRAY . " * " . TF::GREEN . "Jump Boost I" . TF::GRAY . " (3:00)" . PHP_EOL .
											TF::DARK_GRAY . " * " . TF::GREEN . "Strength I" . TF::GRAY . " (0:30)" . PHP_EOL .
											TF::DARK_GRAY . " * " . TF::GREEN . "Night Vision" . TF::GRAY . " (6:00)" . PHP_EOL .
											TF::DARK_GRAY . " * " . TF::GREEN . "Fire Resistance" . TF::GRAY . " (6:00)");
													 
						$player->getInventory()->addItem($pvp);
					        return true;
							 
						break;
						 
					}
				}
			}
		}
		
		if(!$sender->hasPermission("vmcore.command.cp")) {
					
			$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You don't have permission to use this command.");
			return true;
		}

		else {
				
			$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::GOLD . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "Usage: /custompotion (player) (potion)");
			return true;
		}		
	}
}
