<?
function smarty_function_url($params, &$smarty)
{
	foreach($params as $key => $val)
	{
		switch($key)
		{
			case 'type':
			case 'action':
				$$key = $val;
			break;
			default:
				if (stripos($key, 'var')===0 && $val!='')
				{
					$var[$key]=$val;
				}
			break;
		}
	}

	$url=$_SERVER['PHP_SELF'];
	if ($action) $url.="-".$action;
	if (count($var))
	{
		ksort($var);
		
		$var=array_map("urlencode", $var);
		$url.=".".implode('/', $var);
	}
	
	if ($_SERVER['PHP_SELF']!="/" || $action)
	{
		if (!$type) $url.=$smarty->_tpl_vars['ext'];
		else $url.=".".$type;
	}
	return $url;
}
?>