<?php

namespace Lambo\CombatLogger;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\event\Event;
use pocketmine\event\EventPriority;
use pocketmine\event\Listener;
use pocketmine\event\TranslationContainer;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class Main extends PluginBase implements Listener{

    public $players = array();
    public $interval = 10;
    public $blockedcommands = array();

    public function onEnable(){
        $this->saveDefaultConfig();
        $this->interval = $this->getConfig()->get("interval");
        $cmds = $this->getConfig()->get("blocked-commands");
        foreach($cmds as $cmd){
            $this->blockedcommands[$cmd]=1;
        }
        $this->getServer()->getLogger()->info("CombatLogger enabled");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new Scheduler($this, $this->interval), 20);
    }

    public function onDisable(){
        $this->getServer()->getLogger()->info("CombatLogger disabled");
    }

    /**
     * @param EnityDamageEvent $event
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function EntityDamageEvent(EntityDamageEvent $event){
        if($event instanceof EntityDamageByEntityEvent){
            if($event->getDamager() instanceof Player and $event->getEntity() instanceof Player){
                foreach(array($event->getDamager(),$event->getEntity()) as $players){
                    $this->setTime($players);
                }
            }
        }
    }

    private function setTime(Player $player){
        $msg = "§7[§cCombatLogger§7]§c Logging out now will cause you to die.\n§cPlease wait ".$this->interval." seconds.§r";
        if(isset($this->players[$player->getName()])){
            if((time() - $this->players[$player->getName()]) > $this->interval){
                $player->sendMessage($msg);
            }
        }else{
            $player->sendMessage($msg);
        }
        $this->players[$player->getName()] = time();
    }

    /**
     * @param PlayerDeathEvent $event
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function PlayerDeathEvent(PlayerDeathEvent $event){
        if(isset($this->players[$event->getEntity()->getName()])){
            unset($this->players[$event->getEntity()->getName()]);
            /*$cause = $event->getEntity()->getLastDamageCause();
            if($cause instanceof EntityDamageByEntityEvent){
                $e = $cause->getDamager();
                if($e instanceof Player){
                    $message = "death.attack.player";
                    $params[] = $e->getName();
                    $event->setDeathMessage(new TranslationContainer($message, $params));
                }
            }*/
        }
    }

    /**
     * @param PlayerQuitEvent $event
     *
     * @priority HIGH
     * @ignoreCancelled true
     */
    public function PlayerQuitEvent(PlayerQuitEvent $event){
        if(isset($this->players[$event->getPlayer()->getName()])){
            $player = $event->getPlayer();
            if((time() - $this->players[$player->getName()]) < $this->interval){
                $player->kill();
            }
        }
    }

    /**
     * @param PlayerCommandPreprocessEvent $event
     *
     * @priority HIGH
     * @ignoreCancelled true
     */
    public function PlayerCommandPreprocessEvent(PlayerCommandPreprocessEvent $event){
        if(isset($this->players[$event->getPlayer()->getName()])){
            $cmd = strtolower(explode(' ', $event->getMessage())[0]);
            if(isset($this->blockedcommands[$cmd])){
                $event->getPlayer()->sendMessage("§7[§cCombatLogger§7]§c You cannot use this command during combat.§r");
                $event->setCancelled();
            }
        }
    }
}