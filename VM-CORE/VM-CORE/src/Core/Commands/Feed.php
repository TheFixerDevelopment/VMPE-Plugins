<?php

namespace Core\Commands;

use Core\Loader;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class Feed extends PluginCommand {
	
	private $main;

    public function __construct($name, Loader $main) {
		
        parent::__construct($name, $main);
        $this->main = $main;
		
    }
	
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		
		if(!$sender instanceof Player) {
			
			$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You must run this command in-game.");
		
		}
		
		if($sender->hasPermission("vmcore.command.feed") || $sender->isOp()) {
				
			if($sender instanceof Player) {
					
				$sender->setFood(20);
				$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::GREEN . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "Your hunger has been restored.");
				
			}
		}
		
		elseif(!$sender->hasPermission("vmcore.command.feed")) {
				
			$sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You don't have permission to use this command.");
				
		}
	}
}
