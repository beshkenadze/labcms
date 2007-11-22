<?
if (access('edit') || access('add')) $_SESSION['access_files']=1;

if ($_SERVER["REQUEST_METHOD"]=="POST")
{ 
	$folio_path = $_SERVER["PHP_SELF"];
	$error=array();
	$folio['folio_title']=trim($_POST['folio_title']);
	$folio['folio_text']=trim($_POST['folio_text']);
	if (!$folio['folio_text'])
	{
		$errors[]="Не введен текст новости";
	}

	if (!preg_match('/\d{2}\.\d{2}\.\d{4}/', $_POST['folio_date']))
	{
		$errors[]="Неправильный формат даты";
	}
	else
		$folio_date=preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/', '$3-$2-$1', $_POST['folio_date']);
	if (!$errors)
	{
		if ($mode=="add")
		{
			$db->query("INSERT INTO ?_folio SET ?a, folio_date=?", $folio, $folio_date);
		}
		if ($mode=="edit")
		{
			$db->query("UPDATE ?_folio SET ?a, folio_date=? WHERE folio_id=?", $folio, $folio_date, $folio_id);
		}
		refresh('ok', $folio_path);
	}
}

if ($mode=="delete")
{
	$db->query("DELETE FROM ?_folio WHERE folio_id=?", $folio_id);
	refresh('ok', $folio_path);
}

include $_SERVER["DOCUMENT_ROOT"]."/spaw2/spaw.inc.php";

$mod_template='edit_folio.tpl';

if ($mode=="edit")
{
	if (!count($errors))
	{
		$new=$db->selectRow("SELECT folio_title, folio_text, DATE_FORMAT(folio_date, '%d.%m.%Y') as folio_date FROM ?_folio WHERE folio_id=?", $folio_id);
		$Value = $new['folio_text'];
		$smarty->assign($new);
	}
	else
	{
		$Value = $_POST['folio_text'];
	}
}

if($mode=="add")
{
	if (!$_POST['art_date']) $smarty->assign("folio_date", date("d.m.Y"));
	if ($_POST['art_content']) $Value = $_POST['folio_text'];
}

//SpawConfig::setStaticConfigItem('default_toolbarset','mini');
 $spaw = new SpawEditor("folio_text",$Value);

$spaw->setConfigItem(
  'PG_SPAWFM_SETTINGS',
    array(
      'allow_upload' => true,
      'recursive' => true,
      'allow_modify_subdirectories' => true,
      'allow_create_subdirectories' => true,
      'chmod_to' => true,
      'max_upload_filesize' => 0,
      'allowed_filetypes' => array('images', 'flash', 'documents'),
    ),
  SPAW_CFG_TRANSFER_SECURE
);

 $spawn_content = $spaw->getHtml();
$smarty->assign("folio_text_fck", $spawn_content);
$smarty->assign("errors", $errors);
?>