<?
if(!$action){
    $action = $_GET["action"];
}
include("functions.php");
    switch($action){
        case "check":
            include dirname(__FILE__)."/check.php";
        break;
        case "retrive":
            include dirname(__FILE__)."/retrive.php";
        break;
        default:
	        include dirname(__FILE__)."/lost.php";
	    break;
    }
?>
