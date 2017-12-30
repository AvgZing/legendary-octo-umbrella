<?php
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
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerAchievementAwardedEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerMoveEvent;
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
class EventListener implements Listener {
  
  const PREFIX = C::GOLD . "[" . C::BLUE . "PluginName" . C::GOLD . "] ". C::RESET . C::WHITE;
// Good enough for you?
}
?>