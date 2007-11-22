<?
if(!$action){
    $action = $_GET["action"];
}
switch($action){
	    case "update":
	        include dirname(__FILE__)."/update.php";
	    break;
	    case "stats":
            include dirname(__FILE__)."/stats.php";
        break;
        case "view":
            include dirname(__FILE__)."/view.php";
        break;
        default:
	        include dirname(__FILE__)."/user_info.php";
	    break;
    }
?>
