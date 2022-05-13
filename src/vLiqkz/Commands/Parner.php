<?
namespace vLiqkz\Commands;
use pocketmine\command\{Command, CommandSender};
class AdminPartner extends Command{
    public function __construct(){
		parent::__construct("AdminPartner", "Con este comando puedes crear un partner para el menu", "/createPartner [String: Name]", ["createPartner", "cpartner"]);
	}
    public function execute(CommandSender $sender, string $commandLabel, array $args): void{
        if(emply($args)){
            $sender->sendMessage('');
            return;
        }
        $func = $args[0];
        switch (strtolower($func)) {
            case 'edit':
                if(!$args[1]){
                    $sender->sendMessage('necesitas el nombre del partner para editarlo');
                    return;
                }
                
                $pname = '';
                for($i = 1; $i < count($args); $i++){
                    $pname = $pname + $args[$i];
                }
                //code
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
            case 'remove':
            if(!$args[1]){
            $pname = '';
                for($i = 1; $i < count($args); $i++){
                    $pname = $pname + $args[$i];
                }
            }
            Main::DeletePartner($pname);
            break;
            default:
            $sender->sendMessage('funcion no encontrada');
                break;
        }
    }
}