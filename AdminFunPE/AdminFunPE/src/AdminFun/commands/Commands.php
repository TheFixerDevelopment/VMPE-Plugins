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
 * 
 */
namespace AdminFun\commands;

use AdminFun\commands\BaseCommand;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use pocketmine\level\sound\LaunchSound;
use pocketmine\math\Vector3; 
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\event\entity\EntityDamageEvent;;
use pocketmine\entity\Entity;

class Commands extends BaseCommand{

	public function onCommand(CommandSender $issuer, Command $cmd, string $label, array $args) : bool{
		switch($cmd->getName()):
			case "adminfun":
				if(isset($args[0])){
					switch($args[0]):
						case "announce":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.announce")){
								if(count($args) > 1){
									unset($args[0]);
									$msg = implode(" ", $args);
									$this->getPlugin()->getServer()->broadcastMessage(str_replace(array(
											"&",
											"%msg%"
									), array(
											"§",
											$msg
									), $this->getPlugin()->getConfig()->get("announce-format")));
									return true;
								} else{
									$issuer->sendMessage("Usage: /af announce <msg>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "tell":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.tell")){
								if(isset($args[1]) && isset($args[2])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										unset($args[0], $args[1]);
										$msg = implode(" ", $args);
										$target->sendMessage($msg);
										$issuer->sendMessage("Sent Message '$msg' to $target");
									return true;
									} else{
										$issuer->sendMessage("Invalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af tell <player> <message>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "bgod":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.bgod")){
								if(count($args) > 1){
									unset($args[0]);
									$msg = implode(" ", $args);
									$this->getPlugin()->getServer()->broadcastMessage(str_replace(array(
											"&",
											"%msg%"
									), array(
											"§",
											$msg
									), $this->getPlugin()->getConfig()->get("bgod-format")));
									return true;
								} else{
									$issuer->sendMessage("Usage: /af bgod <msg>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "bherobrine":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.bherobrine")){
								if(count($args) > 1){
									unset($args[0]);
									$msg = implode(" ", $args);
									$this->getPlugin()->getServer()->broadcastMessage(str_replace(array(
											"&",
											"%msg%"
									), array(
											"§",
											$msg
									), $this->getPlugin()->getConfig()->get("bherobrine-format")));
									return true;
								} else{
									$issuer->sendMessage("Usage: /af bherobrine <msg>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "broadcast":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.broadcast")){
								if(count($args) > 1){
									unset($args[0]);
									$msg = implode(" ", $args);
									$this->getPlugin()->getServer()->broadcastMessage(str_replace("&", "§", $msg));
									return true;
								} else{
									$issuer->sendMessage("Usage: /af broadcast <msg..>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "burn":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.burn")){
								if(isset($args[1]) && isset($args[2])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										if(is_numeric($args[2])){
											$target->setOnFire($args[2]);
											$issuer->sendMessage("§a" . $target->getName() . " has catched on fire!");
											$target->sendMessage("§eNeed an extinguisher? §m§blol");
											return true;
										} else{
											$issuer->sendMessage("§cInvalid time!");
											return true;
										}
									} else{
										$issuer->sendMessage("Invalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af burn <player> <seconds>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "confuse":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.confuse")){
								if(isset($args[1])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										if($this->getPlugin()->isConfused($target) !== true){
											$this->getPlugin()->confuse($target);
											$issuer->sendMessage("§aYou confused " . $target->getName() . "!");
											return true;
										} else{
											$this->getPlugin()->unConfuse($target);
											$issuer->sendMessage("§aYou unconfused " . $target->getName() . "!");
											return true;
										}
									} else{
										$issuer->sendMessage("§cInvalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af confuse <player>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "console":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.console")){
								if(count($args) > 1){
									unset($args[0]);
									$msg = implode(" ", $args);
									$this->getPlugin()->getServer()->broadcastMessage("§o§7[CONSOLE: " . $msg . "§7]");
									return true;
								} else{
									$issuer->sendMessage("Usage: /af console <msg>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "slap":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.slap")){
								if(isset($args[1]) && isset($args[2])){
									$player = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($player !== null){
										if(is_numeric($args[2])){
											if($player->getDirection() == 0){
												$player->knockBack($player, $args[2], 1, 0, 1);
											}
											elseif($player->getDirection() == 1){
												$player->knockBack($player, $args[2], 0, 1, 1);
											}
											elseif($player->getDirection() == 2){
												$player->knockBack($player, $args[2], -1, 0, 1);
											}
											elseif($player->getDirection() == 3){
												$player->knockBack($player, $args[2], 0, -1, 1);
											}											
											$issuer->sendMessage("§a" . $player->getName() . " been slapped! muahhshssh");
											$player->sendMessage("§eWEEEEE");
											return true;
										} else{
											$issuer->sendMessage("§cInvalid intensity!");
											return true;
										}
									} else{
										$issuer->sendMessage("Invalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af slap <player> <int>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;						
						case "explode":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.explode")){
								if($issuer instanceof Player){
									if(isset($args[1])){
										if(is_numeric($args[1])){
											if(isset($args[2])){
												$target = $this->getPlugin()->getServer()->getPlayer($args[2]);
												if($target !== null){
													$explosion = new Explosion(new Position($target->x, $target->y, $target->z, $target->getLevel()), $args[1]);
													$explosion->explodeA();
													$explosion->explodeB();
													$issuer->sendMessage("§e§lEXPLODE!!");
													return true;
												} else{
													$issuer->sendMessage("§cInvalid target!");
													return true;
												}
											} else{
												$explosion = new Explosion(new Position($issuer->x, $issuer->y, $issuer->z, $issuer->getLevel()), $args[1]);
												$explosion->explode();
												$issuer->sendMessage("§e§lEXPLODE!!");
												return true;
											}
										} else{
											$issuer->sendMessage("§cInvalid radius!");
											return true;
										}
									} else{
										$issuer->sendMessage("Usage: /af explode <radius> <player>");
										return true;
									}
								} else{
									$issuer->sendMessage("§cCommand only works in-game!");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "fakejoin":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.fakejoin")){
								if(isset($args[1])){
									$this->getPlugin()->getServer()->broadcastMessage(str_replace(array(
											"&",
											"%name%"
									), array(
											"§",
											$args[1]
									), $this->getPlugin()->getConfig()->get("fakejoin-format")));
									return true;
								} else{
									$this->getPlugin()->getServer()->broadcastMessage(str_replace(array(
											"&",
											"%name%"
									), array(
											"§",
											$issuer->getName()
									), $this->getPlugin()->getConfig()->get("fakejoin-format")));
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "zap":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.zap")){
								if(isset($args[1])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										$target->sendMessage("§l§eZAP!!!");
										$issuer->sendMessage("§3You zapped " . $target->getName() . "!");
										
										$level = $target->getLevel();
										$light = new AddEntityPacket();
										$light->type = 93;
										$light->entityRuntimeId = Entity::$entityCount++;
										$light->metadata = array();
										$light->speedX = 0;
										$light->speedY = 0;
										$light->speedZ = 0;
										$light->yaw = $target->getYaw();
										$light->pitch = $target->getPitch();
										$light->x = $target->x;
										$light->y = $target->y;
										$light->z = $target->z;
										foreach($level->getPlayers() as $pl){
											$pl->dataPacket($light);
										} 										
										return true;
									} else{
										$issuer->sendMessage("Invalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af zap <player>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;						
						case "fakeop":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.fakeop")){
								if(isset($args[1])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										$target->sendMessage("§7You are now op!");
										$issuer->sendMessage("§3You fakeopped " . $target->getName() . "!");
										return true;
									} else{
										$issuer->sendMessage("Invalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af fakeop <player>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "fakequit":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.fakequit")){
								if(isset($args[1])){
									$this->getPlugin()->getServer()->broadcastMessage(str_replace(array(
											"&",
											"%name%"
									), array(
											"§",
											$args[1]
									), $this->getPlugin()->getConfig()->get("fakequit-format")));
									return true;
								} else{
									$this->getPlugin()->getServer()->broadcastMessage(str_replace(array(
											"&",
											"%name%"
									), array(
											"§",
											$issuer->getName()
									), $this->getPlugin()->getConfig()->get("fakequit-format")));
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "help":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.help")){
								if(! isset($args[1])){
									$issuer->sendMessage("§2Showing help page §6(1/3)");
									$issuer->sendMessage("§l§b- §r§f/adminfun announce <msg..>");
									$issuer->sendMessage("§l§b- §r§f/adminfun bgod <msg..>");
									$issuer->sendMessage("§l§b- §r§f/adminfun bherobrine <msg..>");
									$issuer->sendMessage("§l§b- §r§f/adminfun broadcast <msg..>");
									$issuer->sendMessage("§l§b- §r§f/adminfun burn <player> <seconds>");
									$issuer->sendMessage("§l§b- §r§f/adminfun confuse <player>");
									$issuer->sendMessage("§l§b- §r§f/adminfun console <msg..>");
									$issuer->sendMessage("§l§b- §r§f/adminfun explode <player> <radius>");
									return true;
								} else{
									if(is_numeric($args[1])){
										switch($args[1]):
											case 1:
												$this->getPlugin()->getServer()->dispatchCommand($issuer, "af help");
												return true;
											break;
											case 2:
												$issuer->sendMessage("§aShowing help page §6(2/3)");
												$issuer->sendMessage("§l§b- §r§f/adminfun fakejoin <name>");
												$issuer->sendMessage("§l§b- §r§f/adminfun fakeop <player>");
												$issuer->sendMessage("§l§b- §r§f/adminfun fakequit <name>");
												$issuer->sendMessage("§l§b- §r§f/adminfun freeze <player>");
												$issuer->sendMessage("§l§b- §r§f/adminfun help <1|2|3>");
												$issuer->sendMessage("§l§b- §r§f/adminfun maxhealth <hearts>");
												$issuer->sendMessage("§l§b- §r§f/adminfun playerchat <player> <msg..>");
												$issuer->sendMessage("§l§b- §r§f/adminfun randomtp <troll/safe> <player>");
												return true;
											break;
											case 3:
												$issuer->sendMessage("§aShowing help page §6(3/3)");
												$issuer->sendMessage("§l§b- §r§f/adminfun reload");
												$issuer->sendMessage("§l§b- §r§f/adminfun rocket <player>");
												$issuer->sendMessage("§l§b- §r§f/adminfun spamcast <msg..>");
												$issuer->sendMessage("§l§b- §r§f/adminfun swap <player1> <player2>");
												$issuer->sendMessage("§l§b- §r§f/adminfun void <player>");
												$issuer->sendMessage("§l§b- §r§f/adminfun zap <player>");
												$issuer->sendMessage("§l§b- §r§f/adminfun tell <player> <msg>");	
												$issuer->sendMessage("§l§b- §r§f/adminfun invlock <player>");	
												$issuer->sendMessage("§l§b- §r§f/adminfun slap <player> <strength>");												
												return true;
											break;
										endswitch
										;
									} else{
										$this->getPlugin()->getServer()->dispatchCommand($issuer, "af help");
										return true;
									}
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "swap":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.swap")){
								if(isset($args[1]) && isset($args[2])){
									$player = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($player1 !== null){
										if(is_numeric($args[2])){
											$issuer->sendMessage(TextFormat::GREEN . "You slapped " . $target->getName() . "!");
											if($target->getDirection() == 0){
												$player->knockBack($player, $args[2], 1, 0, 1);
											}
											elseif($player->getDirection() == 1){
												$player->knockBack($player, $args[2], 0, 1, 1);
											}
											elseif($player->getDirection() == 2){
												$player->knockBack($player, $args[2], -1, 0, 1);
											}
											elseif($player->getDirection() == 3){
												$player->knockBack($player, $args[2], 0, -1, 1);
											}
											$player->sendMessage("WEEEEE!!!!!");
											return true;
										}else{
											$issuer->sendMessage("§cInvalid Intensity!");
										}
									} else{
										$issuer->sendMessage("§cInvalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af slap <player> <intensity>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "freeze":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.freeze")){
								if(isset($args[1])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										if($this->getPlugin()->isFrozen($target) !== true){
											$this->getPlugin()->freeze($target);
											$issuer->sendMessage($target->getName() . " §ahas been frozen!");
											$target->sendMessage("§eYou have been §bfrozen§e!");
											return true;
										} else{
											$this->getPlugin()->unfreeze($target);
											$issuer->sendMessage($target->getName() . " §ahas been unfrozen!");
											$target->sendMessage("§eYou have been §cunfrozen§e!");
											return true;
										}
									} else{
										$issuer->sendMessage("§cInvalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af freeze <player>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "invlock":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.invlock")){
								if(isset($args[1])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										if($this->getPlugin()->isLocked($target) !== true){
											$this->getPlugin()->lock($target);
											$issuer->sendMessage($target->getName() . " §ahas been locked!");
											$target->sendMessage("§eYou have been §blocked§e!");
											return true;
										} else{
											$this->getPlugin()->unlock($target);
											$issuer->sendMessage($target->getName() . " §ahas been unlocked!");
											$target->sendMessage("§eYou have been §cunlocked§e!");
											return true;
										}
									} else{
										$issuer->sendMessage("§cInvalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af invlock <player>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;						
						case "maxhealth":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.morehealth")){
								if($issuer instanceof Player){
									if(isset($args[1])){
										if(is_numeric($args[1])){
											$issuer->setMaxHealth($args[1] * 2);
											$issuer->setHealth($issuer->getMaxHealth());
											$issuer->sendMessage("§aSet " . $args[1] . " hearts as your max health!\n§a+ Healed you!");
											return true;
										} else{
											$issuer->sendMessage("§cInvalid numbers of hearts!");
											return true;
										}
									} else{
										$issuer->sendMessage("Usage: /af maxhealth <hearts>");
										return true;
									}
								} else{
									$issuer->sendMessage("§cCommand only works in-game!");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "playerchat":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.playerchat")){
								if(isset($args[1]) && count($args) > 2){
									$target = str_replace("&", "§", $args[1]);
									unset($args[1]);
									unset($args[0]);
									$msg = implode(" ", $args);
									$this->getPlugin()->getServer()->broadcastMessage(str_replace(array(
											"&",
											"%name%",
											"%msg%"
									), array(
											"§",
											$target,
											$msg
									), $this->getPlugin()->getConfig()->get("playerchat-format")));
									return true;
								} else{
									$issuer->sendMessage("Usage: /af playerchat <player> <msg..>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "randomtp":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.randomtp")){
								if($issuer instanceof Player){
									if(isset($args[1])){
										switch($args[1]):
											case "troll":
												if(isset($args[2])){
													$target = $this->getPlugin()->getServer()->getPlayer($args[2]);
													if($target !== null){
														$target->setGamemode(0);
														$target->teleport(new Position(rand(0, 255), rand(0, 255), rand(0, 255), $target->getLevel()));
														$issuer->sendMessage("§aYou teleported " . $target->getName() . " to a random location!");
														$target->sendMessage("§l§eLOL");
														return true;
													} else{
														$issuer->sendMessage("§cInvalid target!");
														return true;
													}
												} else{
													$issuer->sendMessage("§cIf you choose 'troll', you must enter the target's name!  You won't troll yourself right..?");
													return true;
												}
											break;
											case "safe":
												if(isset($args[2])){
													$target = $this->getPlugin()->getServer()->getPlayer($args[2]);
													if($target !== null){
														$x = rand(0, 255);
														$z = rand(0, 255);
														$y = rand(0, 200);
														$target->teleport($target->getLevel()->getSafeSpawn(new Vector3($x, $y, $z)));
														$issuer->sendMessage("§aTeleported " . $target->getName() . " to a safe random location");
														return true;
													} else{
														$issuer->sendMessage("§cInvalid target!");
														return true;
													}
												} else{
													$x = rand(0, 255);
													$z = rand(0, 255);
													$y = rand(0, 200);
													$issuer->teleport($issuer->getLevel()->getSafeSpawn(new Vector3($x, $y, $z)));
													$issuer->sendMessage("§aTeleported to a safe random location");
													return true;
												}
											break;
											default:
												$issuer->sendMessage("§cInvalid args[1]");
												return true;
										endswitch
										;
									} else{
										$issuer->sendMessage("Usage: /af randomtp troll|safe <player>");
										return true;
									}
								} else{
									$issuer->sendMessage("Command only works in-game!");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "reload":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.reload")){
								$this->getPlugin()->saveDefaultConfig();
								$this->getPlugin()->reloadConfig();
								$issuer->sendMessage("§bAdminFun §ahas been reloaded!");
								return true;
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "rocket":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.rocket")){
								if(isset($args[1])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										$target->getLevel()->addSound(new LaunchSound($target));
										$motion = new Vector3($target->motionX, $target->motionY, $target->motionZ);
										$motion->y = 20;
										$target->setMotion($motion);
										$target->sendMessage("§b§lYou turned into a rocket!");
										$issuer->sendMessage("§aYou turned " . $target->getName() . " into a rocket!");
										return true;
									} else{
										$issuer->sendMessage("§cInvalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af rocket <player>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "spamcast":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.spamcast")){
								if(count($args) > 1){
									foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $p){
										unset($args[0]);
										$msg = implode(" ", $args);
										for($i = 0; $i < 20; $i ++){
											$p->sendMessage("§l[SpamCast] §3" . $msg);
										}
										$issuer->sendMessage("§aMessage has been spammed!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af spamcast <msg..>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "swap":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.swap")){
								if(isset($args[1]) && isset($args[2])){
									$player1 = $this->getPlugin()->getServer()->getPlayer($args[1]);
									$player2 = $this->getPlugin()->getServer()->getPlayer($args[2]);
									if($player1 !== null && $player2 !== null){
										if($player1->getName() != $player2->getName()){
											$x1 = $player1->x;
											$y1 = $player1->y;
											$z1 = $player1->z;
											$w1 = $player1->getLevel();
											$x2 = $player2->x;
											$y2 = $player2->y;
											$z2 = $player2->z;
											$w2 = $player2->getLevel();
											$player2->teleport(new Position($x1, $y1, $z1, $w1));
											$player1->teleport(new Position($x2, $y2, $z2, $w2));
											$issuer->sendMessage(TextFormat::GREEN . "You swap " . $player1->getName() . "'s and " . $player2->getName() . "'s position!");
											return true;
										} else{
											$issuer->sendMessage("§cYou cannot swap between the same person!");
											return true;
										}
									} else{
										$issuer->sendMessage("§cInvalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af swap <player1> <player2>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
						case "void":
							if($issuer->hasPermission("adminfun.command") || $issuer->hasPermission("adminfun.command.void")){
								if(isset($args[1])){
									$target = $this->getPlugin()->getServer()->getPlayer($args[1]);
									if($target !== null){
										$target->teleport(new Position($target->x, 0, $target->z, $target->getLevel()));
										$target->sendMessage("§l§aWelcome to the void!");
										$issuer->sendMessage("§aYou teleported " . $target->getName() . " to the void!");
										return true;
									} else{
										$issuer->sendMessage("§cInvalid target!");
										return true;
									}
								} else{
									$issuer->sendMessage("Usage: /af void <player>");
									return true;
								}
							} else{
								$issuer->sendMessage("§cYou don't have permission for this!");
								return true;
							}
						break;
					endswitch
					;
				} else{
					return false;
				}
			break;
		endswitch
		;
		return true;
	}

}
