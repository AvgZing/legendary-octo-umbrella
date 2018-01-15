<?php
namespace Royal;

use pocketmine\event\Listener;

class EventListener implements Listener {
  
  private $plugin;

  public function __construct(\Royal\Main $plugin){//you need one of these
    $this->plugin = $plugin;
  }

}