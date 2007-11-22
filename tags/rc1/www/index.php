<?php /* Created on: 24.06.2006 */ ?>
<?php
if(!file_exists("./kernel/configs/install.lock")) exit(header("Location: ./install/index.php"));
//if (!isset($_GET['debug'])) {echo "на сайте ведуться работы.<br />Загляните через пару часов и все будет в шоколаде!:)"; exit;}
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$time_start = getmicrotime();

require_once "kernel/functions/functions.php";
require_once "kernel/configs/config.php";

//убираем все слеши от магических кавычек
if (get_magic_quotes_gpc())
{
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);
	$_COOKIE = stripslashes_deep($_COOKIE);
}

if (intval($_GET['referral'])) //если передан реферал, то сохраняем его в куках
{
	setcookie('referral', $_GET['referral'], time()+$config['referral_live']*60, '/');
}

//создаем массив, в котором будут содержаться все переменные относящиеся к ядру.
$core=Array();

Header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
Header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
Header("Cache-Control: no-cache, must-revalidate");
Header("Cache-Control: post-check=0,pre-check=0");
Header("Cache-Control: max-age=0");
Header("Pragma: no-cache");
//print_r($_SESSION);
$user_info=auth();
//print_r($_GET);exit;
$smarty->assign("user_info", $user_info);
$error404=false;

$url="/".$_GET['url'];
if (substr($url, -1, 1)=="/" && $url!="/")  $url=substr($url, 0, strlen($url)-1);

$_SERVER['PHP_SELF']=$url;

if (!is_array($_SESSION['core'][$url]))
{

	$result=$db->selectRow("SELECT t.tree_id, parent_id FROM ?_tree_val JOIN ?_tree t USING(tree_id) WHERE path=? LIMIT 1", $url);
	$core['id']=$result['tree_id'];
	$core['parent_id']=$result['parent_id'];

	if (!$core['id']) $error404=true;
		if(!$error404)
		{
			$result=$db->selectRow("SELECT group_id, params, template, tree_name FROM ?_tree_val WHERE tree_id=?d and `show`=1", $core['id']);
			if (!count($result)) //если такая страница не найдена, то показываем ошибку 404
			{
				$error404=true;
			}
			else
			{
				//если в параметрах передан id, то дынный узел является ссылкой
				if (preg_match('/^id=(\d+)$/',trim($result['params']),$var_id))
				{
					$core['id']=$var_id[1];
					$result=$db->selectRow("SELECT group_id, params, template, tree_name FROM ?_tree_val WHERE tree_id=?d and `show`=1", $core['id']);
					if (!count($result))
					{
						$error404=true;
					}
				}

				if (!$error404)
				{
					$inc_group_id=$result['group_id'];
					$core['params']=$result['params'];
					$core['template']=$result['template'];
					$core['tree_name']=$result['tree_name'];
				}

			}
		}

	if (!$error404)
	{
		$parent_tmp=$core['parent_id'];
		$id_tmp=$core['id'];
		$modules_count=0;

		while (!$core['template'] || !$modules_count)
		{
			//если нет выбранных модулей
			if (!$modules_count)
			{
				if (!is_null($inc_group_id)) $sql_param=" OR group_id=$inc_group_id";
				$core['result_mod']=$db->select("SELECT distinct(i.module_id), module, component  FROM ?_includes i JOIN ?_modules m USING(module_id) WHERE (tree_id=".$id_tmp.$sql_param.") AND m.disable = 0 ORDER BY component DESC");
				$modules_count=count($core['result_mod']);
			}
			//если не выбран шаблон или не выбраны модули, то запрашиваем шаблон родителя и идентификатор его родителя
			if (!$modules_count || !$core['template'])
			{
				$result=$db->selectRow("SELECT t.tree_id, parent_id, group_id, params, template FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id WHERE t.tree_id=?d", $parent_tmp);
				$id_tmp=$result['tree_id'];
				$parent_tmp=$result['parent_id'];
				$inc_group_id=$result['group_id'];
				$params_tmp=$result['params'];
				$core['template']=$result['template'];
			}
			//если шаблон уже есть, то запрашиваем только идентификатор родителя. без шаблона
			elseif (!$modules_count && $core['template'])
			{
				$result=$db->selectRow("SELECT t.tree_id, parent_id, group_id, params FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id WHERE t.tree_id=?d", $parent_tmp);
				$id_tmp=$result['tree_id'];
				$parent_tmp=$result['parent_id'];
				$inc_group_id=$result['group_id'];
				$params_tmp=$result['params'];
			}
			//если же модуль уже есть, а шаблона по прежнему нет, то запрашиваем шаблон родителя
			elseif($modules_count && !$core['template'])
			{
				$result=$db->selectRow("SELECT parent_id, template FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id WHERE t.tree_id=?", $parent_tmp);
				$core['template']=$result['template'];
				$parent_tmp=$result['parent_id'];
			}
			if (!$core['params']) $core['params']=$params_tmp;
			if(!$parent_tmp)
			{
				$parent_flag=true; //если достигли верха дерева, то ставим флаг на следующий проход
			}
			elseif($parent_flag)
			{
				break; //после обработки верхнего уровня - выходим.
			}
		}

		//помещаем в массив $core['level'] всех родителей текущего узла
		full_path($core['id']);
		//определяем язык текущий ветви
		current_lang();
		$_SESSION['core'][$url]=$core;
	}
}
else
{
	$core=$_SESSION['core'][$url];
}
$core['data_type']=$_GET['data_type'];

//разбираем параметры полученные из БД
$var_arr=explode("&", $core['params']);
foreach ($var_arr as $val)
{
	$vars=explode("=", $val);
	if($vars[0]=="id") $core['id']=$vars[1];
	if($vars[0]=="data_type") $core['data_type']=$vars[1];
	${$vars[0]}=$vars[1];
}

	//подключаем общие css
	if($css=glob(TEMPLATE_PATH.$config['skin']."/css/*.css"))
		foreach($css as $css_item)
		{
			$smarty->append('css', array("path"=>"css/".basename($css_item), "media"=>basename($css_item, ".css")));
		}
	//подключаем общие JS
	if($js=glob(TEMPLATE_PATH.$config['skin']."/js/*.js"))
		foreach($js as $js_item)
		{
			$smarty->append('js', "js/".basename($js_item));
		}
	
	if($error404) error404();
	
	//получаем права на все модули
	$core['access']=rules();


foreach($core['result_mod'] as $core['inc'])
{
	$tmp_included=include_modules($core['inc']);
	if ($tmp_included)
	{
		$core['included'][]=$tmp_included;
		include MODS_PATH.$core['inc']['module']."index.php";
		if ($mod_template) assign_module($mod_template, $core['inc']['module'], $core['inc']['component']);
	}

}

//подключаем статические модули, которые еще не были подключены
$result_mod=$db->select("SELECT distinct(i.module_id), module, component FROM ?_includes i JOIN ?_modules m ON i.module_id=m.module_id WHERE (tree_id IN (?a) OR group_id IN (SELECT group_id FROM ?_tree_val WHERE tree_id IN (?a))) AND m.static=1 {AND m.module_id NOT IN (?a)}", $core['level'], $core['level'], ($core['included'] ? $core['included'] : 0));
foreach($result_mod as $core['inc'])
{
	$tmp_included=include_modules($core['inc']);
	if ($tmp_included)
	{
		$core['included'][]=$tmp_included;
		include MODS_PATH.$core['inc']['module']."index.php";
		if ($mod_template) assign_module($mod_template, $core['inc']['module'], $core['inc']['component']);
	}
}

$smarty->assign("title", strip_tags($titlepage));
$smarty->assign("catcher", $config['catcher']);

$time_end = getmicrotime();
$s = $db->_statistics;
$sql = $s["time"];
$sqlCount = $s["count"];
$total = ($time_end - $time_start);
$php = $total-$sql;
$smarty->assign("stat", "Время генерации: ".sprintf("%01.3f сек.", $total).", PHP: ".sprintf("%01.3f сек.", $php).", SQL: ".sprintf("%01.3f сек.", $sql)." при $sqlCount запросах");
if (!file_exists($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH.$config['skin']."/".$core['template'].".tpl"))
{
	if (!file_exists($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH.$config['skin']."/default.tpl"))
	$core['template']=$_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH."default/blank";
	else
	$core['template']="default";
}
$smarty->display($core['template'].".tpl",$cache_id);

function getmicrotime()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
//echo "<br>".memory_get_usage();
?>


