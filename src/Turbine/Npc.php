<?php

declare(strict_types=1);

namespace Turbine;

use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\level\Level;
use pocketmine\Player;

use Turbine\Main;

class Npc extends Human {

  public function __construct(\pocketmine\level\Level $level, \pocketmine\nbt\tag\CompoundTag $nbt){
    $skinData = new \Turbine\utils\Skin();
    $skin = new \pocketmine\entity\Skin('npc_skin', $skinData->getRandSkin(), "", "geometry.humanoid.custom", "");
    $this->setSkin($skin);
  parent::__construct($level, $nbt);
  }

  public function getNamedTag(){
    return $this->namedtag;
  }

  public function lookAtXYZ($x, $y, $z){
    $lx = $this->x - $x;
    $ly = $this->y - $y;
    $lz = $this->z - $z;
  if(sqrt($lx * $lx + $lz * $lz) == 0 || sqrt($lx * $lx + $lz * $lz + $ly * $ly) == 0){
    return true;
  }
    $yaw = asin($lx / sqrt($lx * $lx + $lz * $lz)) / 3.14 * 180;
    $pitch = round(asin($ly / sqrt($lx * $lx + $lz * $lz + $ly * $ly)) / 3.14 * 180);
  if($lz > 0){
    $yaw =- $yaw + 180;
  }
    return array($yaw, $pitch);
  }

  public function look(Player $player){
  if($player instanceof Player){
    $plugin = Main::getInstance();
  if(round($player->getPosition()->distance(new \pocketmine\math\Vector3($this->x, $this->y, $this->z))) <= 10){
    $pk = new \pocketmine\network\mcpe\protocol\MovePlayerPacket();
    $pk->entityRuntimeId = $this->getId();
    $yp = $this->lookAtXYZ($player->x, $player->y, $player->z);
    $pk->yaw = $yp[0];
    $pk->headYaw = $yp[0];
    $pk->pitch = $yp[1];
    $pk->position = new \pocketmine\math\Vector3($this->x, $this->y + 1.62, $this->z);
    $player->dataPacket($pk);
    }
   }
  }
}
