<?php 

namespace J0k3rrWild\ChatRewardEvent\Tasks; 

use pocketmine\scheduler\Task;
use pocketmine\level\particle\FloatingTextParticle; 
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use J0k3rrWild\ChatRewardEvent\Main;
use pocketmine\utils\TextFormat as TF;


class RepeaterRender extends Task{


    public function __construct(Main $main){ 
       $this->plugin = $main; 
       
       
       
    } 


    public function onRun(int $tick){ 

        $n=$this->plugin->settings->get("Length");;
        $characters = $this->plugin->settings->get("Characters");
        $randomString = '';
          
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
           $this->plugin->rendered = $randomString;
         
        
          
        $this->plugin->getServer()->broadcastMessage(TF::GREEN.$this->plugin->settings->get("code-message").TF::GOLD.$this->plugin->rendered); 
     


      
     }
        

}