<?
$mod_template="default.tpl";
if (!$_GET['search']) $_GET['search']=$_GET['var2'];
$page=intval($_GET['var1']);
if ($page < 1) $page = 1;
	
	
$config['search_results_at_page']=15;
$count=0;

 //разделяем фразу на отдельные слова, выделяем у них корень и составляем поисковый запрос
$text_array=explode(" ", trim($_GET['search']));
$stemmer = new Lingua_Stem_Ru();

	//определяем с какой страницы запрашивать
	$start=($page-1)*$config['search_results_at_page'];
	$limit=$config['search_results_at_page'];
	
//формируем условия для всех слов
foreach ($text_array as $val)
{
 $query_text.=(($val)?("+".$stemmer->stem_word($val)."* "):"");
}

$search_modules=$db->select("SELECT module, name, module_id FROM ?_modules WHERE search=1");
foreach($search_modules as $search_module)
{
	include MODS_PATH.$search_module['module']."mod_search.php";
}


if ($count)
{
	$total=ceil($count/$config['search_results_at_page']);
	$smarty->assign("current_page", $page);
	$smarty->assign("total", $total);
}
else
{
	$smarty->assign("no_result",1);
}


?>