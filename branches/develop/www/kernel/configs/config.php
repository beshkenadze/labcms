<?php
reset_session();
setlocale(LC_ALL, 'ru_RU');
setlocale(LC_NUMERIC, 'C');
mb_internal_encoding("UTF-8");

$cmsini = parse_ini_file(dirname(__FILE__)."/cms.ini",true);
$dbuser = $cmsini["mysql"]["dbuser"];
$dblocation = $cmsini["mysql"]["dblocation"];
$dbname = $cmsini["mysql"]["dbname"];
$dbpasswd = $cmsini["mysql"]["dbpasswd"];

// Подключаем библиотеку для работы с БД.
require_once "kernel/engines/DbSimple/Generic.php";
// Подключаемся к БД.
$db = DbSimple_Generic::connect("mysql://$dbuser:$dbpasswd@$dblocation/$dbname");
$db->setErrorHandler('databaseErrorHandler');
//задаем префикс для таблиц
$db->setIdentPrefix($cmsini["mysql"]["prefix"]);
$db->query("set names utf8");

if (!is_array($_SESSION['config']))
{
	$config=$db->selectCol("SELECT name AS ARRAY_KEY, value FROM ?_config");
	$_SESSION['config']=$config;
}
else
{
	$config=$_SESSION['config'];
}


function myLogger_console($db, $sql)
{
	// Находим контекст вызова этого запроса.
	$caller = $db->findLibraryCaller();
	//$tip = "at ".@$caller['file'].' line '.@$caller['line'];
	Debug_HackerConsole_Main::out($sql);
}

function myLogger($db, $sql)
{
	// Находим контекст вызова этого запроса.
	$caller = $db->findLibraryCaller();
	//$tip = "at ".@$caller['file'].' line '.@$caller['line'];
	echo "<xmp title=''>";
	print_r($sql);
	echo "</xmp>";
}


//каталог подключаемых модулей
define(MODS_PATH, "mods/");
//каталог скинов
define(TEMPLATE_PATH, 'template/');

//////////////
//Счетчик
// Способ определения IP-адреса посетителя
// 0 Подходит для большинства хостингов в том числе
// для использования на локальной машине
$obtip = 0;
// 1 На некоторых хостингах ip-адрес посетителя не
// заносится в переменную $REMOTE_ADDR, к ним относится,
// например www.nodex.ru
// $obtip = 1;

//блок смены скина
if (isset($_SESSION['skin']))   $config['skin']=$_SESSION['skin'];

require_once($_SERVER["DOCUMENT_ROOT"].'/kernel/engines/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = $_SERVER["DOCUMENT_ROOT"].'/'.TEMPLATE_PATH.$config['skin'].'/';
$smarty->compile_id = $config['skin'];
$smarty->plugins_dir = array(
$_SERVER["DOCUMENT_ROOT"].'/kernel/engines/Smarty/libs/plugins',
$_SERVER["DOCUMENT_ROOT"].'/kernel/plugins',
);

$smarty->assign($config);
$smarty->compile_dir  = $_SERVER["DOCUMENT_ROOT"].'/template_c/';
$smarty->cache_dir    = $_SERVER["DOCUMENT_ROOT"].'/cache/';
$smarty->assign('base', 'http://'.$_SERVER['SERVER_NAME'].'/'.TEMPLATE_PATH.$config['skin'].'/');
$smarty->caching=0;
$smarty->assign("ver","0.5");
$smarty->assign("build",getRev("\$Rev: 340 $"));

$smarty->register_function('remaining', 'remaining_seconds', false, array('endtime'));
$cache_id = $_SERVER["REQUEST_URI"];

	if ($config['debug_console'] && !in_array($_GET['data_type'], array('js', 'xml')))
	{
		require_once $_SERVER["DOCUMENT_ROOT"].'/kernel/classes/HakersConsole/Main.php';
		new Debug_HackerConsole_Main(true);
		$db->setLogger('myLogger_console');
	}
	
	if ($config['debug_mode'])
	{	
		reset_session_set();
	}
	
if (isset($_GET["debug"]) && ($config['debug_mode'] || $_SESSION['user_info']['group_id']==1))
{
	global $config;
	if ($config['debug_console'])
	{
		require_once $_SERVER["DOCUMENT_ROOT"].'/kernel/classes/HakersConsole/Main.php';
		new Debug_HackerConsole_Main(true);
		$db->setLogger('myLogger_console');
	}
	else
	{
		$db->setLogger('myLogger');
	}
	$smarty->debugging=true;
}

?>
