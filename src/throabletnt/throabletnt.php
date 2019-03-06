<?php

namespace throabletnt;

use pocketmine\plugin\PluginBase;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;

class throabletnt extends PluginBase implements Listener {
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
     public function onInteract(PlayerInteractEvent $e){
         $player = $e->getPlayer();
         if($e->getItem()->getId() == 46){
             $nbt = new CompoundTag("", [
                            "Pos" => new ListTag("Pos", [
                                new DoubleTag("", $player->x),
                                new DoubleTag("", $player->y + $player->getEyeHeight()),
                                new DoubleTag("", $player->z)
                            ]),
                            "Motion" => new ListTag("Motion", [
                                new DoubleTag("", -sin($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)),
                                new DoubleTag("", -sin($player->pitch / 180 * M_PI)),
                                new DoubleTag("", cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI))
                            ]),
                            "Rotation" => new ListTag("Rotation", [
                                new FloatTag("", $player->yaw),
                                new FloatTag("", $player->pitch)
                            ]),
                            ]);
                        $f = 2;
                        $tnt = Entity::createEntity("PrimedTNT", $player->chunk, $nbt, true);
                        $tnt->setMotion($tnt->getMotion()->multiply($f));   
                        $tnt->spawnTo($player);
                        $player->sendMessage("Hi mom");
       }
    }
}
