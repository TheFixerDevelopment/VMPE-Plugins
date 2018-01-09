<?php

namespace emanuele0204;

use pocketmine\command\{Command, CommandSender};
use pocketmine\entity\Entity;
use pocketmine\{Server, Player};

class PlayerSize extends Command{
    
    private $p;
    public function __construct($plugin){
        $this->p = $plugin;
        parent::__construct("size", "Size plugin.");
    }
    
    public function execute(CommandSender $g, string $label, array $args){
        if($g->hasPermission("playersize.size")){
            if(isset($args[0])){
                if(is_numeric($args[0])){
                  if ($args[0] >= 1 && $args[0] <= 5) {
                    $this->p->b[$g->getName()] = $args[0];
                    $g->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $args[0]);
                    $g->sendMessage("§8» §aSize changed in §2".$args[0]." §aSuccesfully! §bCheck you out! :)");
                }elseif($args[0] == "reset"){
                    if(!empty($this->p->b[$g->getName()])){
                        unset($this->p->b[$g->getName()]);
                        $g->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, 1.0);
                        $g->sendMessage("§8» §aNormal return size!");
                    }else{
                        $g->sendMessage("§8» §cUse §f/size §ereset §cor §f/size §e<size>");
                    }
                }else{
                    $g->sendMessage("§8» §cI'm sorry, but the size must be between §40.5 §cnd §45. (1 = Normal) (5 = Big)");
               }
            }
         }
      }
   }
}
