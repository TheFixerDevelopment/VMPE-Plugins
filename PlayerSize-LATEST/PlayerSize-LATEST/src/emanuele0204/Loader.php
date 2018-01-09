<?php

namespace emanuele0204;

use pocketmine\plugin\PluginBase;
use pocketmine\entity\Entity;
use pocketmine\{Server, Player};

class Loader extends PluginBase{
    
    public $b = array();
    public function onEnable(){
        $this->getLogger()->info("§8» §ePlayerSize active, loaded.");
        $this->getServer()->getCommandMap()->register("size", new PlayerSize($this));
    }
    
    public function respawn(PlayerRespawnEvent $e){
        $o = $e->getPlayer();
        if(!empty($this->b[$o->getName()])){
            $nomep = $this->b[$o->getName()];
            $o->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $nomep);
        }
    }
}
