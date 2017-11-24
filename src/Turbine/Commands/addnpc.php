<?php

declare(strict_types=1);

namespace Turbine\commands;

use pocketmine\Player;
use pocketmine\utils\TextFormat as C;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use Turbine\Main;

class addnpc extends VanillaCommand {
    
  private $plugin;

  public function __construct(Main $plugin){
    $this->plugin = $plugin;
    parent::__construct('addnpc', 'adds a npc', '/addnpc');
    $this->setPermission('plugins.command');//you can change this if you want
  }

  public function execute(CommandSender $sender, $alias, array $args) : bool {
  if($sender instanceof Player){
  if($sender->isOp()){
  if($args != null){
    $x = $sender->getX();
    $y = $sender->getY();
    $z = $sender->getZ();
    $level = $sender->getLevel();
    $pos = new \pocketmine\level\Position($x, $y, $z, $level);
    $displayName = (string)$args[0];
    $this->plugin->addNPC($pos, $displayName);
    return true;
  } else {
    $sender->sendMessage(C::RED .'no args');
    return false; 
   }
  } else {
    $sender->sendMessage(C::RED .'You must be an op to issue this command!');
    return false;     
  }
  } else {
    $sender->sendMessage(C::RED .'Must run this in game');
    return false;
   }
  }
}
