<?php

//I was too lazy to change this, so I just copied the stuff from PurePerms lmao
//And yes, I know this is way too many use statements, but idgaf I'll do it anyways
namespace _64FF00\PurePerms;

//Blocks
use pocketmine\block\Block;

//Command
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

//Entity
use pocketmine\entity\Entity;
use pocketmine\entity\Effect;

//Events
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\entity\EntityLevelChangeEvent; 
use pocketmine\event\player\PlayerTransferEvent;

//Inventory
use pocketmine\inventory\ChestInventory;
use pocketmine\inventory\EnderChestInventory;

//Item
use pocketmine\item\Item;

//Lang

//Level
use pocketmine\level\Level;
use pocketmine\level\Position;

//Math
use pocketmine\math\Vector3;

//Metadata

//Nbt
use pocketmine\nbt\NBT;

//Network
use pocketmine\network\Network;

//Permission
use pocketmine\permission\Permission;

//Plugin
use pocketmine\plugin\PluginBase;

//Scheduler
use pocketmine\scheduler\PluginTask;

//Tile
use pocketmine\tile\Sign;
use pocketmine\tile\Chest;

//Utils
use pocketmine\utils\TextFormat as C;
use pocketmine\utils\Config;

//Other
use pocketmine\Player;
use pocketmine\Server;
use _64FF00\PurePerms\NPC;

class Transfer extends PluginBase implements listener
{ 
const PREFIX = C::GOLD . "[" . C::BLUE . "Transfer INDEV" . C::GOLD . "] ". C::RESET . C::WHITE;
  public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(self::PREFIX . "Plugin loaded!");
    }
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		 switch(strtolower($command->getName())){
			 case "addnpc":
            if($sender instanceof Player && $sender->isOp()){
			$x = $sender->getX();
			$y = $sender->getY();
			$z = $sender->getZ();
			$pos = "$x, $y, $z";
			$yaw = $sender->getYaw();
			$pitch = $sender->getPitch();
			$displayName = "$args[0]";
			$this->addNPC($pos, $yaw, $pitch, $displayName);
			
#			$args[0] = $player;
#			$args[1] = $address;
#			$args[2] = $port;
#			$args[3] = $message;
#			This is old, I'll make it so like "on tap" stuff later lol
#			$player->transfer($address, $port, $message); 
		}else{
			$sender->sendMessage(C::RED . "You must be an op to issue this command!");
		}
	}
	}
	
  public function addNpc(\pocketmine\level\Position $pos, $yaw, $pitch, string $displayName) : void {
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
      new FloatTag("", intval($yaw)),
      new FloatTag("", intval($pitch))
    ]);
    $nbt->Name = new StringTag("Name", $displayName);
    $npc = Entity::createEntity("Npc", $pos->level, $nbt);
  if($npc instanceof \Plexus\entity\Npc){
    $npc->setNameTag($displayName);
    $npc->setDefaultYawPitch($yaw, $pitch);
    $npc->spawnToAll();
    $this->getPlugin()->npc[] = $npc;
   }
  }
}