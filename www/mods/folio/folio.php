<?php
$mod_template="folio.tpl";
$titlepage = "Списки работ";
if ($folio_id)
{
	$folio=$db->select("SELECT folio_date, folio_title, folio_text, folio_id FROM ?_folio WHERE folio_id=?", $folio_id);
	if($config['folio_anonce_tag'] and $config['folio_anonce_tag']!="none"){
				$anonce = explode($config['folio_anonce_tag'],$folio[0]['folio_text']);
				$folio[0]['folio_text']=$anonce;
				$folio[0]['anonce'] = 1;
				$folio[0]['full'] = 1;
				$core['nav']['path'][]= "";
				$core['nav']['name'][]= $folio[0]["folio_title"];
				$core['comment']['module_id']=$core['inc']['module_id'];
				$core['comment']['item_id']=$folio[0]['folio_id']; // идентификатор текущей записи
	}
}
else
{
	$count=$db->selectCell("SELECT COUNT(folio_id) FROM ?_folio WHERE `folio_date`<=NOW()"); 
	if ($count)
	{
		if ($page < 1) $page = 1;
		if ($page>$total=ceil($count/$config['folio_at_page'])) $page=$total;

		//определяем с какой страницы запрашивать
		$start=($page-1)*$config['folio_at_page'];

		$result=$db->select("SELECT folio_date, folio_title, folio_text, folio_id FROM ?_folio WHERE `folio_date`<=NOW() ORDER BY folio_date DESC LIMIT ?d, ?d", $start, $config['folio_at_page']); 
		foreach($result as $folio_row)
		{
			$anonce=0;
			if ($config['folio_anonce_length'])
			{
				$folio_row['folio_text']=strip_tags($folio_row['folio_text']);
				if (strlen($folio_row['folio_text'])>$config['folio_anonce_length'])
				{
					preg_match('/^(.{1,'.$config['folio_anonce_length'].'})\s/s', $folio_row['folio_text'], $anonce);
					$folio_row['folio_text']=$anonce[1];
					$anonce=1;
				}
			}elseif($config['folio_anonce_tag'] and $config['folio_anonce_tag']!="none"){
				$anonce = explode($config['folio_anonce_tag'],$folio_row['folio_text']);
				$folio_row['folio_text']=$anonce[0];
				$anonce=1;
			}
			$folio[]=array('folio_id'=>$folio_row['folio_id'],
							'folio_date'=>$folio_row['folio_date'],
							'folio_title'=>$folio_row['folio_title'], 
							'folio_text'=>$folio_row['folio_text'],
							'anonce'=>$anonce);
		}
		$smarty->assign("current_page", $page);
		$smarty->assign("total", $total);
	}
}
$smarty->assign("folio", $folio);

$smarty->assign("access_add", access('add'));
$smarty->assign("access_edit", access('edit'));
$smarty->assign("access_delete", access('delete'));
?>
