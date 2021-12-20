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

    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->saveResource("config.yml"); 
        $task = new RepeaterRender($this); 
        $this->getScheduler()->scheduleRepeatingTask($task,50*20); // Counted in ticks (1 second = 20 ticks)
        $this->getLogger()->info(TF::GREEN."[ChatRewardEvent] > Plugin oraz konfiguracja została załadowana pomyślnie");
    }


    public function lotto($player){   
        $this->index = 0;
        $chance = mt_rand(1, 100);
        // Wczytanie configa
        $this->cfg = $this->getConfig()->getAll();

            
        for ($i = 1; $i < count($this->cfg)+1; $i++) {
            
            $this->chanceArray[$i] = $this->cfg[$i]["szansa"];
            // var_dump($this->chanceArray[$i]);
           }

        //    var_dump($this->chanceArray);

        for ($i = 1; $i <= count($this->cfg); $i++) {
            
           $itemAmounts = $this->chanceArray[$i];
           
               
            for ($y = 1; $y<=$itemAmounts; $y++) {
            
             $this->index++;
             $this->idArray[$this->index] = $this->cfg[$i]["id"];
             $this->nameArray[$this->index] = $this->cfg[$i]["nazwa"];
             $this->amountArray[$this->index] = $this->cfg[$i]["ilosc"];
                // var_dump($this->nameArray[$this->index]);
                
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
        var_dump($word);
        var_dump($wordlen);
     if($wordlen === 10){ 
       if($word === $this->rendered){
           $this->lotto($e->getPlayer());

       }
      
    }
        
        // if($e->getMessage()){
        
        // }
         
    }
}
