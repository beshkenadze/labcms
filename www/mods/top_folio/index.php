<?
    $mod_template="top_folio.tpl";
	 $result=$db->select("SELECT folio_date, folio_title, folio_text, folio_id FROM ?_folio WHERE folio_date<=NOW() ORDER BY folio_date DESC LIMIT ?d", $config['top_folio']);
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
$smarty->assign('top_folio', $folio);

$smarty->assign("access_add", access('add'));
$smarty->assign("access_edit", access('edit'));
$smarty->assign("access_delete", access('delete'));
?>