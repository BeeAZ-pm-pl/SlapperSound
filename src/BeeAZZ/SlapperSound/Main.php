<?php

namespace BeeAZZ\SlapperSound;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use slapper\events\SlapperHitEvent;

class Main extends PluginBase implements Listener{
  
  public function onEnable():void{
    $this->saveDefaultConfig();
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function onHitSlapper(SlapperHitEvent $event){
   $player = $event->getDamager();
  if($this->getConfig()->get("AddSound") == true){
   if($player instanceof Player){
    $sound = $this->getConfig()->get("sound");
    $volume = $this->getConfig()->get("volume");
    $pitch = $this->getConfig()->get("pitch");
    $this->playSound($player, $sound, $volume, $pitch);
   }
   }
  }
  public function playSound(Player $player, string $sound, float $volume = 0, float $pitch = 0):void {
		$packet = new PlaySoundPacket();
		$packet->soundName = $sound;
		$packet->x = $player->getPosition()->getX();
		$packet->y = $player->getPosition()->getY();
		$packet->z = $player->getPosition()->getZ();
		$packet->volume = $volume;
		$packet->pitch = $pitch;
		$player->getNetworkSession()->sendDataPacket($packet);
}
}
