<?php

namespace BeeAZZ\SlapperSound;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use slapper\events\SlapperHitEvent;

class Main extends PluginBase implements Listener{

  protected $cfg;
  
  protected function onEnable():void{
    $this->saveDefaultConfig();
    $this->cfg = $this->getConfig();
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function onHitSlapper(SlapperHitEvent $event){
   $player = $event->getDamager();
   if($this->cfg->get("AddSound") === true){
    if($player instanceof Player){
     $sound = $this->cfg->get("sound");
     $volume = $this->cfg->get("volume");
     $pitch = $this->cfg->get("pitch");
     $this->playSound($player, $sound, $volume, $pitch);
   }
   }
  }
  protected function playSound($player, string $sound, float $volume = 0, float $pitch = 0): void{
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
