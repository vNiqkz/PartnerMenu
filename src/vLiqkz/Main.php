<?
namespace vLiqkz;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{Config, TextFormat}
class Main extends PluginBase{
    protected $instance;
    public $partners = [];
    public function onLoad(): void{
        self::$instance = $this;
    }
    public function onEnable(): void{

    }
    public function getInstance(): self{
        return self::$instance;
    }
    public function CreatePartner(String $pname): bool{
        $config = new Config(self::getInstance()->getDataFolder()."partner.yml", Config::YAML);
        if($config->exists($pname)){
            return false;
        }
        $config->set($pname, [
            
        ])
    }
}