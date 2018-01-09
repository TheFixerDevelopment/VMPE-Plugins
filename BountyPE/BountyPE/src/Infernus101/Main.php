<?php

/*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*/

namespace Infernus101;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\{Command, CommandSender};
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener{
    public $db;
	public function onEnable(){
    $this->getLogger()->info("§b§lLoaded Bounty by Zeao succesfully.");
		$files = array("config.yml");
		foreach($files as $file){
			if(!file_exists($this->getDataFolder() . $file)) {
				@mkdir($this->getDataFolder());
				file_put_contents($this->getDataFolder() . $file, $this->getResource($file));
			}
		}
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$this->db = new \SQLite3($this->getDataFolder() . "bounty.db");
		$this->db->exec("CREATE TABLE IF NOT EXISTS bounty (player TEXT PRIMARY KEY COLLATE NOCASE, money INT);");
	}
    	public function bountyExists($playe) {
		$result = $this->db->query("SELECT * FROM bounty WHERE player='$playe';");
		$array = $result->fetchArray(SQLITE3_ASSOC);
		return empty($array) == false;
	    }
		public function getBountyMoney($play){
        $result = $this->db->query("SELECT * FROM bounty WHERE player = '$play';");
        $resultArr = $result->fetchArray(SQLITE3_ASSOC);
        return (int) $resultArr["money"];
        }
		public function onEntityDamage(EntityDamageEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof Player){
			$player = $entity->getPlayer();
			if($this->cfg->get("bounty_stats") == 1 or $this->cfg->get("health_stats") == 1){
		    $this->renderNametag($player);
		    }
		  }
	    }
	    public function onEntityRegainHealth(EntityRegainHealthEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof Player){
			$player = $entity->getPlayer();
			if($this->cfg->get("bounty_stats") == 1 or $this->cfg->get("health_stats") == 1){
		    $this->renderNametag($player);
		    }
		  }
	    }
		public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		 if($this->cfg->get("bounty_stats") == 1 or $this->cfg->get("health_stats") == 1){
		 $this->renderNametag($player);
		 }
	    }
		public function getBountyMoney2($play){
		  if(!$this->bountyExists($play)){
			  $i = 0;
			  return $i;
		  }
        $result = $this->db->query("SELECT * FROM bounty WHERE player = '$play';");
        $resultArr = $result->fetchArray(SQLITE3_ASSOC);
        return (int) $resultArr["money"];
        }
	    public function deleteBounty($pla){
		$this->db->query("DELETE FROM bounty WHERE player = '$pla';");
	    }
		public function addBounty($player, $mon){
		if($this->bountyExists($player)){
		   $stmt = $this->db->prepare("INSERT OR REPLACE INTO bounty (player, money) VALUES (:player, :money);");  	
           $stmt->bindValue(":player", $player);
		   $stmt->bindValue(":money", $this->getBountyMoney($player) + $mon);
		   $result = $stmt->execute();	   
		 }
		 if(!$this->bountyExists($player)){
		   $stmt = $this->db->prepare("INSERT OR REPLACE INTO bounty (player, money) VALUES (:player, :money);");  	
           $stmt->bindValue(":player", $player);
		   $stmt->bindValue(":money", $mon);
		   $result = $stmt->execute();	   
	     }
		}
		public function renderNameTag($player){
		$username = $player->getName();
		$lower = strtolower($username);
		$bounty = $this->getBountyMoney2($lower);
		if($this->cfg->get("bounty_stats") == 1 && $this->cfg->get("health_stats") != 1){
		$player->setNameTag("§a$username\n§eBounty: §6$bounty"."$");
		}
		if($this->cfg->get("health_stats") == 1 && $this->cfg->get("bounty_stats") != 1){
		$player->setNameTag("§a$username §c".$player->getHealth()."§f/§c".$player->getMaxHealth());
		}
		if($this->cfg->get("bounty_stats") == 1 && $this->cfg->get("health_stats") == 1){
		$player->setNameTag("§a$username §c".$player->getHealth()."§f/§c".$player->getMaxHealth()."\n§eBounty: §6$bounty"."$");
		}
	    }
		public function onDeath(PlayerDeathEvent $event) {
        $cause = $event->getEntity()->getLastDamageCause();
        if($cause instanceof EntityDamageByEntityEvent) {
            $player = $event->getEntity();
			$name = $player->getName();
			$lowr = strtolower($name);
            $killer = $event->getEntity()->getLastDamageCause()->getDamager();
			$name2 = $killer->getName();
			if($player instanceof Player){
				if($this->bountyExists($lowr)){
					$money = $this->getBountyMoney($lowr);
					$killer->sendMessage("§6[BOUNTY]>§b §bYou get extra §3$money §bfrom bounty for killing §3$name"."§b!");
					EconomyAPI::getInstance()->addMoney($killer->getName(), $money);
					if($this->cfg->get("bounty_broadcast") == 1){
			          $this->getServer()->broadcastMessage("§6[BOUNTY]> §2$name2 §ajust got §2$money"."$ §abounty for killing §2$name!");
		            }
				if($this->cfg->get("bounty_fine") == 1){
					$perc = $this->cfg->get("fine_percentage");
					$fine = ($money*$perc)/100;
					if(EconomyAPI::getInstance()->myMoney($player->getName()) > $fine){
					  	EconomyAPI::getInstance()->reduceMoney($player->getName(), $fine);
						$player->sendMessage("§6[BOUNTY]>§bYour §3$fine"."$ §bwas taken as Bounty fine! Bounty Fine = §3$perc §bPercent of Bounty on you!");
					}
					if(EconomyAPI::getInstance()->myMoney($player->getName()) <= $fine){
					  	EconomyAPI::getInstance()->setMoney($player->getName(), 0);
						$player->sendMessage("§6[BOUNTY]>§bYour §3$fine"."$ §bwas taken as Bounty fine! Bounty Fine = §3$perc §bPercent of Bounty on you!");
					}
				}
					$this->deleteBounty($lowr);
				}
		 }
    }
}
	    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		////////////////////// BOUNTY //////////////////////
		 if(strtolower($cmd->getName()) == "bounty"){	
		   if(!isset($args[0])){
		        $sender->sendMessage("§cWrong command. §dPlease use: §5/bounty <set | me | search | top | about>");
			    return false;
		   }	
		 switch(strtolower($args[0])){
		 case "set":
		   if(!(isset($args[1])) or !(isset($args[2]))){
			   $sender->sendMessage("§cWrong usage. §dPlease use: §5/bounty set <player> <money>");
			   return true;
			   break;
		   }
		   $invited = $args[1];
		   $lower = strtolower($invited);
		   $name = strtolower($sender->getName());
		   if($lower == $name){
			   $sender->sendMessage("§6[BOUNTY]> §dYou cannot place bounties on yourself!");
			   return true;
			   break;
		   }
		    $playerid = $this->getServer()->getPlayerExact($lower);
			$money = $args[2];
		   if(!$playerid instanceof Player) {
			   $sender->sendMessage("§6[BOUNTY]> §dPlayer not found!");
			   return true;
			   break;
		   }
		   if(!is_numeric($args[2])) {
			   $sender->sendMessage("§cWrong usage. §dPlease use: §5/bounty set $args[1] <money>\n§bBOUNTY> §6Money has to be a number!");
			   return true;
			   break;
		   }
		   $min = $this->cfg->get("min_bounty");
		   if($money < $min){
			  $sender->sendMessage("§6[BOUNTY]> §dMoney has to be more than $min"."$");
			  return true;
			  break;
		   }
		   if($fail = EconomyAPI::getInstance()->reduceMoney($sender, $money)) {
		   $player = $sender->getName();
		   $this->addBounty($lower, $money);
		   $sender->sendMessage("§bBOUNTY> §aSuccessfully added §6$money"."$ §abounty on §e$invited");
		   $playerid->sendMessage("§bBOUNTY> §aA Bounty has been added on you for §2$money"."$ §aby §2$name\n§6Check total bounty on you by typing: §d/bounty me");
		   if($this->cfg->get("bounty_broadcast") == 1){
			   $this->getServer()->broadcastMessage("§6[BOUNTY]> §r§3$player §bJust added §3$money"."$ §bbounty on §3$invited!");
		   }
	           return true;
		   break;
		   }else {
						switch($fail){
							case EconomyAPI::RET_INVALID:
								$sender->sendMessage("§6[BOUNTY]> §5You do not have enough money to set that bounty!");
								return false;
								break;
							case EconomyAPI::RET_CANCELLED:
								$sender->sendMessage("§bBOUNTY> §6ERROR!");
								break;
							case EconomyAPI::RET_NO_ACCOUNT:
								$sender->sendMessage("§bBOUNTY> §6ERROR!");
								break;
						}
					}
		   break;
		   case "me":
			   $lower = strtolower($sender->getName());
			   if(isset($args[1])){
				   $sender->sendMessage("§dPlease use: §5/bounty me");
				   return true;
				   break;
			   }
			   if(!$this->bountyExists($lower)){
				   $sender->sendMessage("§d=+=+=+=+=+=+= §bBounty §d=+=+=+=+=+=+=\n§aNo current bounties detected on you!\n§d=+=+=+=+=+=+= §bBounty §d=+=+=+=+=+=+=");
				   return true;
				   break;
			   }
			   if($this->bountyExists($lower)){
				   $bounty = $this->getBountyMoney($lower);
				   $sender->sendMessage("§d=+=+=+=+=+=+= §bBounty §d=+=+=+=+=+=+=\n§aBounty on you: §6$bounty"."$\n§d=+=+=+=+=+=+= §bBounty §d=+=+=+=+=+=+=");
				   return true;
				   break;
			   }
			   break;
		   
		   case "search":
			   if(!isset($args[1])){
				   $sender->sendMessage("§dPlease use: §5/bounty search <player>");
				   return true;
				   break;
			   }
			   $lower = strtolower($args[1]);
			   if(!$this->bountyExists($lower)){
				   $sender->sendMessage("§d=+=+=+=+=+=+= §bBounty §d=+=+=+=+=+=+=\n§aNo curent bounties on $args[1]".".\n§d=+=+=+=+=+=+= §bBounty §d=+=+=+=+=+=+=");
				   return true;
				   break;
			   }
			   if($this->bountyExists($lower)){
				   $bounty = $this->getBountyMoney($lower);
				   $sender->sendMessage("§d=+=+=+=+=+=+= §bBounty §d=+=+=+=+=+=+=\n§aBounty on $args[1]: §6$bounty"."$\n§d=+=+=+=+=+=+= §bBounty §d=+=+=+=+=+=+=");
				   return true;
				   break;
			   }
			       break;
		   case "top":
		       if(isset($args[1])){
				   $sender->sendMessage("§dPlease use: §5/bounty top");
				   return true;
			           break;
			   }
			          $sender->sendMessage("§a--------- §bTop 10 MOST WANTED LIST §a---------");
		              $result = $this->db->query("SELECT * FROM bounty ORDER BY money DESC LIMIT 10;"); 			
				      $i = 1; 
					  while($row = $result->fetchArray(SQLITE3_ASSOC)){
						    $play = $row["player"];
							$money = $row["money"];
							$sender->sendMessage("§f§l$i. §r§a$play §f--> §6$money"."$");
						    $i++; 
			              }
		        return true; 
		    break;
		   case "about":
		    $sender->sendMessage("§5Bounty v2.0.0-beta1 by §aZeao. n§eThis plugin was bought to you by §6Void§bFactions§cPE! §aOur server IP: §cvoidfactionspe.ml Port - 19132");
		   return true; 
		   break;   
		   default:
		    $sender->sendMessage("§dPlease use: §5/bounty <set | me | search | top | about>");
		    return true;
		    break;
			 }
	}
  }
}
