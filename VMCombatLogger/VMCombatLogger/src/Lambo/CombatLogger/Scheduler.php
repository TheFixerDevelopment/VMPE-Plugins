<?php
namespace Lambo\CombatLogger;

use pocketmine\Player;
use pocketmine\scheduler\PluginTask;

class Scheduler extends PluginTask{

    public function __construct($plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }

    public function onRun(int $currentTick){
        foreach($this->plugin->players as $player=>$time){
            if((time() - $time) > $this->plugin->interval){
                $p = $this->plugin->getServer()->getPlayer($player);
                if($p instanceof Player){
                    $p->sendMessage("§7[§cCombatLogger§7]§c You can now logout.§r");
                    unset($this->plugin->players[$player]);
                }else unset($this->plugin->players[$player]);
            }
        }
    }
}
