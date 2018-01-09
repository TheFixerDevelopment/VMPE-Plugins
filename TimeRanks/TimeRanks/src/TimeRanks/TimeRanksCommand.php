<?php

namespace TimeRanks;

use pocketmine\command\CommandSender;
use pocketmine\Player;

class TimeRanksCommand{

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function run(CommandSender $sender, array $args) : bool{
        if(!isset($args[0])){
            $sender->sendMessage("§5(Help page)§6§l>>>>>> §r§aTimeRanks plugin by Zeao §5(Help page)§6§l<<<<<<§r\n§a/ranks check §2- Checks your timed rank.\n§a/ranks check <player> §2- Checks another player's rank.\n§cTimedRanks help page, made by Zeao.");
            $sender->sendMessage("§7Please use: §e/ranks check ".($sender instanceof Player ? "[player]" : "<player>"));
            return true;
        }
        $sub = array_shift($args);
        switch(strtolower($sub)){
            case "check":
                if(isset($args[0])){
                    if(!$this->plugin->getServer()->getOfflinePlayer($args[0])->hasPlayedBefore()){
                        $sender->sendMessage("Player ".$args[0]." §chas never played on §6Void§bFactions§cPE");
                        return true;
                    }
                    if(!$this->plugin->data->exists(strtolower($args[0]))){
                        $sender->sendMessage($args[0]." §ahas played less than 1 minute on §6Void§bFactions§cPE");
                        $sender->sendMessage("§bTheir Rank is: ".$this->plugin->default);
                        return true;
                    }
                    $sender->sendMessage($args[0]." §ahas played§2 ".$this->plugin->data->get(strtolower($args[0]))." §aminutes on §6Void§bFactions§cPE");
                    $sender->sendMessage("§bTheir Rank is: ".$this->plugin->getRank(strtolower($args[0])));
                    return true;
                }
                if(!$this->plugin->data->exists(strtolower($sender->getName()))){
                    if(!($sender instanceof Player)){
                        $sender->sendMessage("§7Please use: §e/ranks check <playername> §6To check another player's rank.\n§7Please use: §e/ranks check §6To check your own rank.");
                        return true;
                    }
                    $sender->sendMessage("§a§lYou have played less than 1 minute ago on §6Void§bFactions§cPE");
                    $sender->sendMessage("§r§bYour rank is: ".$this->plugin->default);
                    return true;
                }
                $sender->sendMessage("§b§lYou have played§r§3 ".$this->plugin->data->get(strtolower($sender->getName()))." §b§lminutes on §6Void§bFactions§cPE");
                $sender->sendMessage("§a§lYour rank is: ".$this->plugin->getRank(strtolower($sender->getName())));
                return true;
            break;
            default:
                return false;
        }
    }

}
