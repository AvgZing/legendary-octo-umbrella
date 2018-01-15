<?php 
namespace Royal\Commands;

use pocketmine\Player;
use pocketmine\utils\TextFormat as C;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\level\Level;

use pocketmine\command\defaults\VanillaCommand;

class addnpc extends VanillaCommand {
    
	private $plugin;
	const PREFIX = C::GOLD . "[" . C::BLUE . "TransferIndev" . C::GOLD . "] ". C::RESET . C::WHITE;
 
	public function __construct(\Royal\Main $plugin){
		$this->plugin = $plugin;
		parent::__construct('addnpc', 'creates an npc', '/addnpc <name>');
		$this->setPermission('plugins.command');
	}
	public function execute(CommandSender $sender, $alias, array $args){
		if($sender instanceof Player){
    if($sender->isOp() === true){
    if(count($args[0]) > null){
			$level = $sender->getLevel();
			$pos = new Position($sender->getX(), $sender->getY(), $sender->getZ(), $level);
			$yaw = (int) $sender->getYaw();
			$pitch = (int) $sender->getPitch();
			
			$this->addNPC($pos, $yaw, $pitch, $args[0]);
			$sender->sendMessage(self::PREFIX . "Command has been run!");
			return true;
				}
			} else {
				$sender->sendMessage(self::PREFIX . "You must be Op to run this Command!");
			return false;
			}
		} else {
			$sender->sendMessage(self::PREFIX . "Command must be run in-game!");
		return false;     
		}
	}
  public function addNpc(\pocketmine\level\Position $pos, int $yaw, int $pitch, string $displayName) : void {
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
      new FloatTag("", $yaw),
      new FloatTag("", $pitch)
    ]);
    $nbt->Name = new StringTag("Name", $displayName);
    $npc = Entity::createEntity("Npc", $pos->level, $nbt);
  if($npc instanceof \Royal\entity\NPC){
    $npc->setNameTag($displayName);
    $npc->setDefaultYawPitch($yaw, $pitch);
    $npc->spawnToAll();
    $this->getPlugin()->npc[] = $npc;
   }
  }
}