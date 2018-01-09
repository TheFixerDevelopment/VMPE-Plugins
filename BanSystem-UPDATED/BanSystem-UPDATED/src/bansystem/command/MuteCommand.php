<?php

namespace bansystem\command;

use bansystem\Manager;
use bansystem\translation\Translation;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class MuteCommand extends Command {
    
    public function __construct() {
        parent::__construct("mute");
        $this->description = "Prevents the given player from sending public chat message.";
        $this->usageMessage = "/mute <player> [reason...]";
        $this->setPermission("bansystem.command.mute");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($this->testPermissionSilent($sender)) {
            if (count($args) <= 0) {
                $sender->sendMessage(Translation::translateParams("usage", array($this)));
                return false;
            }
            $player = $sender->getServer()->getPlayer($args[0]);
            $muteList = Manager::getNameMutes();
            if ($muteList->isBanned($args[0])) {
                $sender->sendMessage(Translation::translate("playerAlreadyMuted"));
                return false;
            }
            if (count($args) == 1) {
                if ($player != null) {
                    $muteList->addBan($player->getName(), null, null, $sender->getName());
                    $sender->getServer()->broadcastMessage(TextFormat::AQUA . $player->getName() . TextFormat::RED . " has been muted by $sender.");
                    $player->sendMessage(TextFormat::RED . "You have been muted from our network\n§4Muted by: §bStaff.");
                } else {
                    $muteList->addBan($args[0], null, null, $sender->getName());
                    $sender->getServer()->broadcastMessage(TextFormat::AQUA . $args[0] . TextFormat::RED . " has been muted from our network!\n§4Muted by: §bStaff.");
                }
            } else if (count($args) >= 2) {
                $reason = "";
                for ($i = 1; $i < count($args); $i++) {
                    $reason .= $args[$i];
                    $reason .= " ";
                }
                $reason = substr($reason, 0, strlen($reason) - 1);
                if ($player != null) {
                    $muteList->addBan($player->getName(), $reason, null, $sender->getName());
                    $sender->getServer()->broadcastMessage(TextFormat::AQUA . $player->getName() . TextFormat::RED . " has been muted by $sender Reason: " . TextFormat::AQUA . $reason . TextFormat::RED . ".");
                    $player->sendMessage(TextFormat::RED . "You have been muted from our network!\§4Muted by: §bStaff\n§5Reason: " . TextFormat::AQUA . $reason . TextFormat::RED . ".");
                } else {
                    $muteList->addBan($args[0], $reason, null, $sender->getName());
                    $sender->getServer()->broadcastMessage(TextFormat::AQUA . $args[0] . TextFormat::RED . " has been muted from our network\n§4Muted by: §bStaff\n§5Reason: " . TextFormat::AQUA . $reason . TextFormat::RED . ".");
                }
            }
        } else {
            $sender->sendMessage(Translation::translate("noPermission"));
        }
        return true;
    }
}
