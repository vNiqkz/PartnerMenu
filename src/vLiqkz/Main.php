<?
namespace vLiqkz;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{Config, TextFormat}
use libs\muqsit\invmenu\{InvMenuHandler, InvMenu};
use libs\muqsit\invmenu\type\InvMenuTypeIds;
class self extends PluginBase{
    protected $instance;
    public $partners = [];
    public function onLoad(): void{
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->saveResource("partner.yml")
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
        $chest = $this->getConfig()->get("Chest");
        $chestId = ''
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
            return true;
        }
        return false;
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