<?php

namespace Core\Commands;

use Core\Loader;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class Heal extends PluginCommand {
	
	private $main;

    public function __construct($name, Loader $main) {
		
        parent::__construct($name, $main);
        $this->main = $main;
		
    }
	
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		
		if(!$sender instanceof Player) {
			
			$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You must run this command in-game.");
		        return true;
		}

		if($sender->hasPermission("vmcore.command.heal") || $sender->isOp()) {
				
			if($sender instanceof Player) {
					
				$sender->setHealth(20);
				$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "Your health has been restored.");
				return true;
			}
		}
		
		elseif(!$sender->hasPermission("vmcore.command.heal")) {
				
			$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You don't have permission to use this command.");
			return true;
		}
	}
}
