<?
use vLiqkz\Main;
use pocketmine\command\{Command, CommandSender};
use pocketmine\player\Player;
class CustomPartner extends Command{
    private $customCommand = Main::getCustomCommand();
    public function __construct(){
        $customCommand = $this->$customCommand();
		parent::__construct($customCommand["name"], $customCommand["descripcion"], $customCommand["uso"], $customCommand["aliases"]);
	}
    public function execute(CommandSender $sender, string $commandLabel, array $args): void{
        if($sender instanceof Player){
            Main::openMenu($sender);
            return;
        }
        $sender->sendMessage('sabes, pudiste haber tirado el servidor.');
    }
}