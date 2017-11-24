<?php

declare(strict_types=1);

namespace Turbine;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

//Command
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

//utils
use pocketmine\utils\TextFormat as C;

class Main extends PluginBase implements Listener {

  public $skins = [];
  public $entities = [];
 
  const PREFIX = C::GOLD . '[' . C::BLUE . 'Turbine In-Dev'. C::GOLD . '] '. C::RESET . C::WHITE;

  public function onEnable(){
    self::$instance = $this;//allows you to get $this/Main from any file
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(self::PREFIX . 'Plugin loaded!');
  }

  public static function getInstance(){
    return self::$instance;
  }

  public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
  switch(strtolower($command->getName())){
  case 'addnpc'://please for the love of god use single quotes XD
  if($sender instanceof Player && $sender->isOp()){
    $x = $sender->getX();
    $y = $sender->getY();
    $z = $sender->getZ();
    $level = $sender->getLevel();
    $pos = new \pocketmine\level\Position($x, $y, $z, $level);
    $displayName = (string)$args[0];
    $this->addNPC($pos, $displayName);
			
/*  $args[0] = $player;
    $args[1] = $address;
    $args[2] = $port;
    $args[3] = $message;
    This is old, I'll make it so like "on tap" stuff later lol
    $player->transfer($address, $port, $message); */
  } else {
    $sender->sendMessage(C::RED .'You must be an op to issue this command!');
    }
   }
  }
	
  public function addNpc(\pocketmine\level\Position $pos, string $displayName) : void {
    $nbt = new CompoundTag;
    $nbt->Pos = new ListTag("Pos", [
      new DoubleTag("", $pos->x + 0.5),
      new DoubleTag("", $pos->y),
      new DoubleTag("", $pos->z + 0.5)
    ]);
    $nbt->Motion = new ListTag("Motion", [
      new DoubleTag("", 0),
      new DoubleTag("", 0),
      new DoubleTag("", 0)
    ]);
    $nbt->Rotation = new ListTag("Rotation", [
      new FloatTag("", 0),
      new FloatTag("", 0)
    ]);
    $nbt->Name = new StringTag("Name", $displayName);
    $npc = Entity::createEntity("Npc", $pos->level, $nbt);
  if($npc instanceof \Turbine\Npc){
    $npc->setNameTag($displayName);
    $npc->spawnToAll();
    $this->entities['npc'][] = $npc;
   }
  }
}
