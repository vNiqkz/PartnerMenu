<?
namespace vLiqkz\Commands;
use pocketmine\command\{Command, CommandSender};
class CreatePartner extends Command{
    public function __construct(){
		parent::__construct("CreatePartner", "Con este comando puedes crear un partner para el menu", "/createPartner [String: Name]", ["createPartner", "cpartner"]);
	}
    //hola tobby xd
    public function execute(CommandSender $sender, string $commandLabel, array $args): void{
        if(emply($args)){
            $sender->sendMessage('necesitas ponerle un nombre al partner');
            return;
        }
        $func = $args[0];
        switch ($func) {
            case 'edit':
                    if(!$args[1]){
                        $sender->sendMessage('necesitas el nombre del partner para editarlo');
                        return;
                    }
                break;
            case 'create':
                if(!$args[1]){
                    $sender->sendMessage('necesitas ponerle un nombre al partner');
                }
                $pname = '';
                for($i = 1; $i < count($args); $i++){
                    $pname = $pname + $args[$i];
                }
                Main::CreatePartner($pname);
                break;
            default:
            $sender->sendMessage('funcion no encontrada');
                break;
        }
        
    }
}