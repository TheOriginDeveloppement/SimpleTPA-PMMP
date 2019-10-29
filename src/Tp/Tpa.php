<?php

namespace Tp;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;

class Tpa extends PluginBase implements Listener{

    public function onEnable(){
          $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info("§lSimple§6TPA §aON");
        $this->askerarr = [];
        $this->vktmarr = [];
        $this->vktmarrhere = [];
        $this->askerarrhere = [];
    }


    public function onQuit(PlayerQuitEvent $ev){
        $player = $ev->getPlayer();
        if(isset($this->vktmarr[strtolower($player->getLowerCaseName())])){
            unset($this->askerarr[$this->asker->getLowerCaseName()]);
            unset($this->vktmarr[$this->vktm->getLowerCaseName()]);
        }elseif(isset($this->askerarr[strtolower($player->getLowerCaseName())])){
            unset($this->askerarr[$this->asker->getLowerCaseName()]);
            unset($this->vktmarr[$this->vktm->getLowerCaseName()]);
        }elseif(isset($this->vktmarrhere[strtolower($player->getLowerCaseName())])){
            unset($this->askerarrhere[$this->asker->getLowerCaseName()]);
            unset($this->vktmarrhere[$this->vktm->getLowerCaseName()]);
        }elseif(isset($this->askerarrhere[strtolower($player->getLowerCaseName())])){
            unset($this->askerarrhere[$this->asker->getLowerCaseName()]);
            unset($this->vktmarrhere[$this->vktm->getLowerCaseName()]);
        }
    }
        
        
        
        
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
        switch($cmd->getName()){
            case "tpa":
            if(!isset($args[0])){
                $sender->sendMessage("§l§cYou must specific player");
            }else {
                $player = $this->getServer()->getPlayer($args[0]);
                if($player === null){
                    $sender->sendMessage("§l§cThis player is not online");
                }else {
                    if(isset($this->vktmarr[strtolower($player->getLowerCaseName())]) or isset($this->askerarr[strtolower($player->getLowerCaseName())]) or  isset($this->vktmarrhere[strtolower($player->getLowerCaseName())]) or  isset($this->askerarrhere[strtolower($player->getLowerCaseName())])){
                
                        $sender->sendMessage("§c§lThis player already have a request");
                       }else{
                    $this->asker = $sender;
                    $this->vktm = $player;
                    $player->sendMessage("§a§l".$sender->getName() . " want teleport to you \n §l§6/tpaccept for accept §5or §c/tpdeny for deny");
                    $sender->sendMessage("§a§lYour request as been send to ". $player->getName());
                    $this->askerarr[$sender->getLowerCaseName()] = true;
                    $this->vktmarr[$player->getLowerCaseName()] = true;

                    }
                }
            }
            break;
            case "tpaccept":
            if(isset($this->vktmarr[strtolower($sender->getLowerCaseName())])){
              $this->asker->sendMessage("§a§l".$sender->getName() . " accept your request");
              $this->vktm->sendMessage("§a§lYou have accepted a request");
              $xyz = new Vector3($this->vktm->getX(),$this->vktm->getY(),$this->vktm->getZ()); 
              $this->asker->teleport($xyz);
              unset($this->askerarr[$this->asker->getLowerCaseName()]);
              unset($this->vktmarr[$this->vktm->getLowerCaseName()]);
            }elseif(isset($this->vktmarrhere[strtolower($sender->getLowerCaseName())])){ 
                $this->asker->sendMessage("§a§l".$sender->getName() . " accept your request");
                $this->vktm->sendMessage("§a§lYou have accepted a request");
                $xyz = new Vector3($this->asker->getX(),$this->asker->getY(),$this->asker->getZ()); 
                $this->vktm->teleport($xyz);
                unset($this->askerarrhere[$this->asker->getLowerCaseName()]);
                unset($this->vktmarrhere[$this->vktm->getLowerCaseName()]);
            }else{
                $sender->sendMessage("§c§lYou dont have request");
            }
            break;
            case "tpahere":
            if(!isset($args[0])){
                $sender->sendMessage("§l§cYou must specific player");
            }else {
                $player = $this->getServer()->getPlayer($args[0]);
                if($player === null){
                    $sender->sendMessage("§l§cThis player is not online");
                }else {
                    if(isset($this->vktmarr[strtolower($player->getLowerCaseName())]) or isset($this->askerarr[strtolower($player->getLowerCaseName())]) or  isset($this->askerarrhere[strtolower($player->getLowerCaseName())]) or  isset($this->vktmarrhere[strtolower($player->getLowerCaseName())])){
                
                        $sender->sendMessage("§c§lThis player already have a request");
                       }else{
                    $this->asker = $sender;
                    $this->vktm = $player;
                    $player->sendMessage("§a§l".$sender->getName() . " sent request to you to teleport to them  \n §l§6/tpaccept for accept §5or §c/tpdeny for deny");
                    $sender->sendMessage("§a§lYour request as been send to ". $player->getName());
                    $this->askerarrhere[$sender->getLowerCaseName()] = true;
                    $this->vktmarrhere[$player->getLowerCaseName()] = true;
                       }
                }
            }
            break;
            case "tpdeny":
            if(isset($this->vktmarr[strtolower($sender->getLowerCaseName())])){
                $this->asker->sendMessage("§c§l".$sender->getName() . " deny your request");
                $this->vktm->sendMessage("§c§lYou have deny a request");
                unset($this->askerarr[$this->asker->getLowerCaseName()]);
                unset($this->vktmarr[$this->vktm->getLowerCaseName()]);
              }elseif(isset($this->vktmarrhere[strtolower($sender->getLowerCaseName())])){ 
                  $this->asker->sendMessage("§c§l".$sender->getName() . " deny your request");
                  $this->vktm->sendMessage("§c§lYou have deny a request");
                  unset($this->askerarrhere[$this->asker->getLowerCaseName()]);
                  unset($this->vktmarrhere[$this->vktm->getLowerCaseName()]);
              }else{
                  $sender->sendMessage("§c§lYou dont have request");
              }
            break;
        }
        return true;
    }
}