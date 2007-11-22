<?
if (access('edit') || access('add')) $_SESSION['access_files']=1;
$core['nav']['path'][]= "";
$mode=="add" ? $core['nav']['name'][]= "Создание новости"  : $core['nav']['name'][]= "Редактирование новости";
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
	$error=array();
	$news['news_title']=trim($_POST['news_title']);
	$news['news_text']=trim($_POST['news_text']);
	$news['lang_id']=($_POST['lang_id'])?$_POST['lang_id']:$config['lang_id'];
	if (!$news['news_text'])
	{
		$errors[]="Не введен текст новости";
	}

	if (!preg_match('/\d{2}\.\d{2}\.\d{4}/', $_POST['news_date']))
	{
		$errors[]="Неправильный формат даты";
	}
	else
		$news_date=preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/', '$3-$2-$1', $_POST['news_date']);
	if (!$errors)
	{
		if ($mode=="add")
		{
			$db->query("INSERT INTO ?_news SET ?a, news_date=?", $news, $news_date);
		}
		if ($mode=="edit")
		{
			$db->query("UPDATE ?_news SET ?a, news_date=? WHERE news_id=?", $news, $news_date, $news_id);
		}
		refresh('OK');
	}
}

if ($mode=="delete")
{
	$db->query("DELETE FROM ?_news WHERE news_id=?", $news_id);

	refresh('OK');
}


$mod_template='edit_news.tpl';

$langs=$db->selectCol("SELECT lang_id AS ARRAY_KEY, lang_name FROM ?_langs");
$smarty->assign("langs", $langs);

if ($mode=="edit")
{
	if (!count($errors))
	{
		$new=$db->selectRow("SELECT news_title, news_text, DATE_FORMAT(news_date, '%d.%m.%Y') as news_date, lang_id FROM ?_news WHERE news_id=?", $news_id);
		$Value = $new['news_text'];
		$smarty->assign($new);
	}
	else
	{
		$Value = $_POST['news_text'];
	}
}

if($mode=="add")
{
	if (!$_POST['news_date']) $smarty->assign("news_date", date("d.m.Y"));
	if ($_POST['news_text']) $Value = $_POST['news_text'];
}

$smarty->assign("news_text", $Value);
$smarty->assign("errors", $errors);
?>