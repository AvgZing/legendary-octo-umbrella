<?php

namespace Royal;
  
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;

class Main extends PluginBase {
	
	private static $instance = null;

	const PREFIX = C::GOLD . "[" . C::BLUE . "Transfer-INDEV" . C::GOLD . "] ". C::RESET . C::WHITE;
	
	public function onEnable(){
		$this->getServer()->getLogger()->info(self::PREFIX . "Loading...");
		$this->getServer()->getPluginManager()->registerEvents(new \Royal\EventListener($this), $this);
		$this->getServer()->getCommandMap()->register('addnpc', new \Royal\Commands\addnpc($this));
		
		@mkdir($this->getDataFolder());//put skins in here...
		self::$instance = $this;

		$this->getServer()->getLogger()->info(self::PREFIX . "Everything has loaded!");  
	}

    /**
	 * to access the main file from any other file
	 * 
	 * do "$main = \Royal\Main::getInstance();
	 * 
	 * or
	 * 
	 * public function getPlugin(){
	 *   return new \Royal\Main::getInstance();
	 * }
	 */
	public static function getInstance() {
		return self::$instance;
	  }
      
	public function onDisable(){
		$this->getServer()->getLogger()->info(self::PREFIX . "Disabling plugin...");
		$this->getServer()->getLogger()->info(self::PREFIX . "Plugin Disabled!");
	}
}