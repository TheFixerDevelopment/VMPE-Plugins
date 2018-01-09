<?php

/*
 * This file is the main class of AdminFun.
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
namespace AdminFun;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\CommandExecutor;
use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use AdminFun\commands\Commands;
use AdminFun\listeners\ConfuseListener;
use AdminFun\listeners\FreezeListener;
use AdminFun\listeners\InvLockListener;

class AdminFun extends PluginBase{
	
	private $lock = [];

	private $frozen = [];

	private $confuse = [];

	public function onEnable(){
		if(! is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		$this->saveDefaultConfig();
		$this->reloadConfig();
		$this->dpdata = new Config($this->getDataFolder() . "dpdata.yml", Config::YAML, array());
		$this->getCommand("adminfun")->setExecutor(new Commands($this));
		$this->getServer()->getPluginManager()->registerEvents(new ConfuseListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new FreezeListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new InvLockListener($this), $this);
		$this->getLogger()->info("§aLoaded Successfully!");
	}

	public function onDisable(){
		unlink($this->getDataFolder() . "dpdata.yml");
	}
	
	// INVLOCK API
	public function isLocked(Player $player){
		return in_array($player->getName(), $this->lock);
	}

	public function lock(Player $player){
		$this->lock[$player->getName()] = $player->getName();
	}

	public function unlock(Player $player){
		unset($this->lock[$player->getName()]);
	}	
	// FREEZE API
	public function isFrozen(Player $player){
		return in_array($player->getName(), $this->frozen);
	}

	public function freeze(Player $player){
		$this->frozen[$player->getName()] = $player->getName();
	}

	public function unfreeze(Player $player){
		unset($this->frozen[$player->getName()]);
	}
	
	// CONFUSE API
	public function confuse(Player $player){
		$this->confuse[$player->getName()] = $player->getName();
	}

	public function unConfuse(Player $player){
		unset($this->confuse[$player->getName()]);
	}

	public function isConfused(Player $player){
		return in_array($player->getName(), $this->confuse);
	}
	
	// DROPPARTY API
	public function getDpdata(){
		return $this->dpdata;
	}

}
