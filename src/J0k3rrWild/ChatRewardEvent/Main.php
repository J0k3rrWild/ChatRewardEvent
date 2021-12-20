<?php

declare(strict_types=1);

namespace J0k3rrWild\ChatRewardEvent;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as TF;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;
use J0k3rrWild\ChatRewardEvent\Tasks\RepeaterRender; 
class Main extends PluginBase implements Listener{
public $rendered;    
    
    
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getLogger()->info(TF::GREEN."[ChatRewardEvent] > Plugin oraz konfiguracja została załadowana pomyślnie");
        $task = new RepeaterRender($this); 
        $this->getScheduler()->scheduleRepeatingTask($task,2*20); // Counted in ticks (1 second = 20 ticks)
    
    }


    public function onChat(PlayerChatEvent $e){
         
    }
}
