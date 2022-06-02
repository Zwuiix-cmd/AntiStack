<?php

namespace Zwuiix\AntiStack;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;

//EVENT
use pocketmine\utils\Config;
use pocketmine\event\entity\EntityInventoryChangeEvent;

use CortexPE\DiscordWebhookAPI\Embed;
use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;

//ITEM
use pocketmine\block\BlockIds;
use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\item\Sword;

class Main extends PluginBase implements Listener
{
    public static $instance;

    public function onEnable()
    {
        self::$instance = $this;
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function removeTask($id) {
        $this->getScheduler()->cancelTask($id);
    }

    public function onLoad(){
        $this->reloadConfig();
    }

    public static function getInstance() : Main {
      return self::$instance;
    }

    public function sendAlert(Player $player){
        $name = $player;

        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);

        $msg = new Message();
        $embed = new Embed();
        $webHook = new Webhook($config->get("webhook"));
        $embed->setDescription("**{$name}** vient d'être expulsé par l'AntiItemStack !");
        $embed->setFooter("Développer par Zwuiix#0001","https://s.namemc.com/2d/skin/face.png?id=b162f285cae40a95&scale=4");
        $msg->addEmbed($embed);
        $webHook->send($msg);
    }

    public function InvChange(EntityInventoryChangeEvent $event) {
        $player = $event->getEntity();
        $oldItem = $event->getOldItem();
        $newItem = $event->getNewItem();
        if ($player instanceof Player) {
            $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
            if($newItem->getId()==438){
                if($newItem->getCount() > 1){
                    $event->setCancelled();
                    $player->kick($config->get("kick-message"), false);

                    if($config->get("webhook") == null) return;
                    $this->sendAlert($player);
                }
            }elseif($newItem->getId() == Item::ENDER_PEARL){
                if($newItem->getCount() > 16){
                    $event->setCancelled();
                    $player->kick($config->get("kick-message"), false);

                    if($config->get("webhook") == null) return;
                    $this->sendAlert($player);
                }
            }elseif($newItem instanceof Armor){
                if($newItem->getCount() > 1){
                    $event->setCancelled();
                    $player->kick($config->get("kick-message"), false);

                    if($config->get("webhook") == null) return;
                    $this->sendAlert($player);
                }
            }elseif($newItem instanceof Tool){
                if($newItem->getCount() > 1){
                    $event->setCancelled();
                    $player->kick($config->get("kick-message"), false);

                    if($config->get("webhook") == null) return;
                    $this->sendAlert($player);
                }
            }elseif($newItem instanceof Sword){
                if($newItem->getCount() > 1){
                    $event->setCancelled();
                    $player->kick($config->get("kick-message"), false);

                    if($config->get("webhook") == null) return;
                    $this->sendAlert($player);
                }
            }
        }
    }
}