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

//nbt tags
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;

//Entity
use pocketmine\entity\Entity;

class Main extends PluginBase implements Listener {

  public $skins = [];
  public $entities = [];

  private static $instance = null;
  
  const PREFIX = C::GOLD . '[' . C::BLUE . 'Turbine In-Dev'. C::GOLD . '] '. C::RESET . C::WHITE;

  public function onEnable(){
    self::$instance = $this;//allows you to get $this/Main from any file
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    Entity::registerEntity(\Turbine\Npc::class, true);
    $this->getServer()->getCommandMap()->register('addnpc', new \Turbine\Commands\addnpc($this));
    $this->getServer()->getLogger()->info(self::PREFIX . 'Plugin loaded!');
  }

  public static function getInstance(){
    return self::$instance;
  }
	
  public function addNpc(\pocketmine\level\Position $pos, string $displayName) : void {
    $this->getServer()->getLogger()->info(self::PREFIX ."Creating npc $displayName");
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
    $this->getServer()->getLogger()->info(self::PREFIX ."Created npc $displayName");
   }
  }
}
