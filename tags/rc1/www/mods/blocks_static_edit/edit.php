<?
$mod_template="edit.tpl";
if ($_SERVER['REQUEST_METHOD']=='POST')
{
	$name=trim($_POST['name']);
	$data=trim($_POST['data']);
	$errors=array();
	
	if (!$name)
	{
		$errors[]="Введите название блока";
	}
	
	if (!count($errors))
	{
		$params=array('name'=>$name,
						'data'=>$data);
		if ($mode=="edit")
		{
			$db->query("UPDATE ?_blocks_static SET ?a WHERE block_id=?", $params, $block_id);
		}
		elseif($mode=="add")
		{
			$params['visible']=1;
			$db->query("INSERT INTO ?_blocks_static SET ?a", $params);
		}
		refresh();
	}
$smarty->assign('errors', $errors);
}
else
{
	$result=$db->selectRow("SELECT * FROM ?_blocks_static WHERE block_id=?", $block_id);
	$smarty->assign($result);
}
?>