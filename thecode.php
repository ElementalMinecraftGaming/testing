<?php

namespace ElementalMinecraftGaming\PlayerGPS;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\server;
use pocketmine\Player;
use pocketmine\level\{Level,Position,ChunkManager};

class Main extends PluginBase implements listener {

    private $hasPc = [];

    public function onEnable() {
        $this->getLogger()->info("PlayerGPS has been enabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($sender->hasPermission("player.locate")) {
            if (strtolower($command->getName()) == "locatep") {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        $sender->sendMessage(TextFormat::GOLD . "Remember to add the name or you'll get an error");
                        $player = $this->getServer()->getPlayer($args[0]);
                        $levels = $player->getLevel()->getFolderName();
                        $z = $player->getZ();
                        $x = $player->getX();
                        $y = $player->getY();
                        $sender->sendMessage(TextFormat::GOLD . "Coordinates are: $levels, $x, $y, $z");
                        return true;
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Incorrect potato!");
                        return false;
                    }
                }
            }
        }
        if ($sender->hasPermission("player.selflocate")) {
            if (strtolower($command->getName()) == "locate") {
                if ($sender instanceof Player) {
                    $a = $sender->getZ();
                    $b = $sender->getX();
                    $c = $sender->getY();
                    $levell = $player->getLevel()->getFolderName();
                    $sender->sendMessage(TextFormat::GOLD . "Coordinates are: $levell, $b, $c, $a");
                    return true;
                } else {
                    $sender->sendMessage(TextFormat::RED . "Incorrect potato!");
                    return false;
                }
            }
        }
        if ($sender->hasPermission("player.tpl")) {
            if (strtolower($command->getName()) == "playertpl") {
                if ($sender instanceof Player) {
                    $sender->sendMessage(TextFormat::GOLD . "Locked on target!");
                    $this->hasPc[$sender->getName()] = true;
                    $player = $this->getServer()->getPlayer($args[0]);
                    $zz = $player->getZ();
                    $xx = $player->getX();
                    $yy = $player->getY();
                    return true;
                } else {
                    $sender->sendMessage(TextFormat::RED . "Incorrect potato!");
                    return false;
                }
            }
        }
        if ($sender->hasPermission("player.unset")) {
            if (strtolower($command->getName()) == "unsetplayerlocate") {
                if ($sender instanceof Player) {
                    $sender->sendMessage(TextFormat::GOLD . "ignoring target!");
                    if (isset($this->hasPc[$event->getPlayer()->getName()])) {
                        unset($this->hasPc[$event->getPlayer()->getName()]);
                    }
                    return true;
                } else {
                    $sender->sendMessage(TextFormat::RED . "Incorrect potato!");
                    return false;
                }
            }
        }
        if ($sender->hasPermission("player.helplocate")) {
            if (strtolower($command->getName()) == "helplocate") {
                if ($sender instanceof Player) {
                    $sender->sendMessage(TextFormat::GOLD . "/plp {name} - locate a player");
                    $sender->sendMessage(TextFormat::GOLD . "/phl - help with locate commands");
                    $sender->sendMessage(TextFormat::GOLD . "/psl - Locate yourself");
                    return true;
                } else {
                    $sender->sendMessage(TextFormat::RED . "Incorrect potato!");
                    return false;
                }
            }
        }
        return false;
    }

    public function onQuit(PlayerQuitEvent $event) {
        if (isset($this->hasPc[$event->getPlayer()->getName()])) {
            unset($this->hasPc[$event->getPlayer()->getName()]);
        }
    }

    public function onToggle(PlayerToggleSneakEvent $event) {
        if (isset($this->hasPc[$event->getPlayer()->getName()])) {
            $player->teleport(new Position($xx, $yy, $zz));
        }
    }

}
