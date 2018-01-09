<?php

/*
 * This file is a part of AdminFun.
 * Copyright (C) 2015 CyberCube-HK
 *
 * AdminFun is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AdminFun is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AdminFun. If not, see <http://www.gnu.org/licenses/>.
 */
namespace AdminFun\listeners;

use AdminFun\listeners\BaseListeners;
use pocketmine\event\inventory\InventoryOpenEvent;

class InvLockListener extends BaseListeners{

	public function onChest(InventoryOpenEvent $event){
		if($this->getPlugin()->isLocked($event->getPlayer())){
			$event->setCancelled(true);
			$event->getPlayer()->sendMessage("§cYou arent allowed to open chests because you are locked, you must find the key!");
		}
	}

}
