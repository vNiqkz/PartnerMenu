<?
namespace vLiqkz;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{Config, TextFormat}
use libs\muqsit\invmenu\{InvMenuHandler, InvMenu};
use libs\muqsit\invmenu\type\InvMenuTypeIds;
use libs\muqsit\invmenu\type\transaction\{InvMenuTransactionResult, InvMenuTransaction};
class self extends PluginBase{
    protected $instance;
    public $partners = [];
    public function onLoad(): void{
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->saveResource("partner.yml");
        $this->saveResource("players.yml");
        $this->saveResource("votes.yml");
    }
    public static function getCustomCommand(): Array{
        return $this->getConfig()->get("Command");
    } 
    public function onEnable(): void{
        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }
    }
    public function getInstance(): self{
        return self::$instance;
    }
    
    public static function openMenu($player): bool{
        $config = $this->getConfig()->get("Chest");
        $chest = $config->get("Chest");
        $title = $config->get("Title");
        $chestId = '';
        switch (strlower($chest)) {
            case 'normal':
                $chestId = InvMenuTypeIds::TYPE_CHEST;
                break;
            case 'double':
                $chestId = InvMenuTypeIds::TYPE_DOUBLE_CHEST;
                break;
            default:
                $chestId = null;
                break;
        }
        if(isset($chestId)){
            $menu = InvMenu::create($chestId);
            $partners = self::getPartnerConfig()->getAll();
            foreach ($partners as $partner){
                if(isset($partner[item])){
                    $menu->getInventory()->setItem($partner[slot], $partner[item]);
                }
            }
            $menu->setName($title);
            $menu->setListener(function(InvMenuTransaction $transaction) : InvMenuTransactionResult{
                $player = $transaction->getPlayer();
                $itemClicked = $transaction->getItemClicked();
                self::voteForPartner($player->getName(), $itemClicked->getId());
                return $transaction->continue();
            });
            return true;
        }
        return false;
    }
    public static function voteForPartner($playerName, $itemId){
       $partner = self::getPartnerByItem($itemId); 
        if(isset($partners)){
            $votes = new Config(self::getInstance()->getDataFolder()."votes.yml", Config::YAML);
            $players = new Config(self::getInstance()->getDataFolder()."players.yml", Config::YAML);
            $players->set($playerName, $partner);
            $votes->set($partner, intval($votes->get($partner)) + 1);
            $players->save();
            $votes->save();
            return;
        }
    }
    public static function getPartnerByItem($itemId){
        $partners = self::getPartnerConfig()->getAll();
        foreach ($partner as $key => $value) {
            if(value["item"]["id"] === $itemId){
                return $key;
            }
        }
        return null;
    }
    public static getPartnerConfig(): Config{
        return new Config(self::getInstance()->getDataFolder()."partner.yml", Config::YAML);
    }
    public static function existPartner($pname): bool{
        $config = self::getPartnerConfig();
        return $config->exists($pname);
    }
    public static function editPartner($pname, $func, $value): bool{
        $config = self::getPartnerConfig();
        if(!iseet($pname)){
            return false;
        }
        if(!self::existPartner($pname)){
            return false;
        }
        $data = $config->get($pname);
        switch ($func) {
            case 'item':
                $data['item'] = $value;
                $config->set($pname, $data);
                $config->save();
            break;
            case 'reward':
                $data['reward'] = $value;
                $config->set($pname, $data);
                $config->save();
            break;
            case 'decoration':
                $data['decoration'] = $value;
                $config->set($pname, $data);
                $config->save();
            break;
            default:
                return false;
            break;
        }
        return true;
    }
    public function DeletePartner(String $pname): bool{
        $config = self::getPartnerConfig();
        if($config->exists($pname)){
            $config->remove($pname);
            return true;
        }
        return false;
    }
    public static function CreatePartner(String $pname): bool{
        $config = self::getPartnerConfig();
        if($config->exists($pname)){
            return false;
        }
        $config->set($pname, null);
    }
}