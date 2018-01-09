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
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class ConfuseListener extends BaseListeners{

	public function onPlayerCommand(PlayerCommandPreprocessEvent $event){
		if($this->getPlugin()->isConfused($event->getPlayer())){
			$msg = $event->getMessage();
			if($msg{0} != "/"){
				// lol md5
				$event->setMessage(md5(md5($event->getMessage())));
			}
		}
	}

}
