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
use pocketmine\item\Item;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

public $rendered;    
public $lotted;    
public $index;
public $chanceArray;
public $idArray;
public $nameArray;
public $amountArray;
public $cfg;
public $cfgload;
public $settings;

    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->saveResource("drop.yml"); 
        $this->saveResource("settings.yml"); 
        $this->cfgload = new Config($this->getDataFolder()."drop.yml", Config::YAML);
        $this->settings = new Config($this->getDataFolder()."settings.yml", Config::YAML);
        $this->cfg = $this->cfgload->getAll();
        $task = new RepeaterRender($this); 
        $this->getScheduler()->scheduleRepeatingTask($task, $this->settings->get("Time")*20); 
        $this->getLogger()->info(TF::GREEN."[ChatRewardEvent] > Plugin oraz konfiguracja została załadowana pomyślnie");
        
        
    
    }


    public function lotto($player){   
        $this->index = 0;
        $chance = mt_rand(1, 100);

        for ($i = 1; $i < count($this->cfg)+1; $i++) {
            
            $this->chanceArray[$i] = $this->cfg[$i]["szansa"];
           
           }

       

        for ($i = 1; $i <= count($this->cfg); $i++) {
            
           $itemAmounts = $this->chanceArray[$i];
           
               
            for ($y = 1; $y<=$itemAmounts; $y++) {
            
             $this->index++;
             $this->idArray[$this->index] = $this->cfg[$i]["id"];
             $this->nameArray[$this->index] = $this->cfg[$i]["nazwa"];
             $this->amountArray[$this->index] = $this->cfg[$i]["ilosc"];
                
                
            }    
        } 
        $player->getInventory()->addItem(Item::get($this->idArray[$chance], 0, $this->amountArray[$chance]));
        $player->sendMessage(TF::GREEN."[MeetMate] > Brawo! Otrzymałeś ".$this->amountArray[$chance]." ".$this->nameArray[$chance]);
        $this->rendered = NULL;
    }


    public function onChat(PlayerChatEvent $e){
        $word = $e->getMessage();
        $wordlen = strlen($e->getMessage());
        $i = 0;
        $cfglen = $this->settings->get("Lenght");
     if($wordlen === $cfglen){
       if($word === $this->rendered){
           $this->lotto($e->getPlayer());

       }
      
    }
        
    
    }
}
