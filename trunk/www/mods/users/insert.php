<?php
/*
 * Created on 04.03.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
if (access('add'))
{
	/*if(preg_match("#\b[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b#i",$_POST["user"]["email"])){
		echo "ok";
	}else{
		echo "no!";
	}*/

	if($_GET["var1"] == "group") {
		
		foreach($_POST["group"] as $key=>$u) {
			$group[$key] = $u;
		}
		if($group_id = $db->query('INSERT INTO ?_groups (?#) VALUES(?a)', array_keys($group), array_values($group))){
	    	foreach($_POST["module"] as $mod) {
				$module_id = is_numeric($mod["module_id"]) ? $mod["module_id"] : refresh("Error: моду", $_SERVER["HTTP_REFERER"],3);
				if($mod["permis"]) {
					$db->query("DELETE FROM ?_access WHERE `group_id` = ? AND module_id = ?", $group_id,$module_id);
					$db->query("INSERT INTO ?_access SET `group_id` = ?, `module_id`=?, `permis`=(?)",$group_id,$module_id,implode(",",array_keys($mod["permis"])));
				}
			}
	    	refresh('ok',$_SERVER["PHP_SELF"]."-show.group/".$group_id.$config['ext']);
	    }else{
	   	 $db->setErrorHandler('databaseErrorHandler');
	   	 exit;
	    }
	}else{
		$row = $_POST["user"];
		
		if(empty($row["pass"]) OR empty($row["pass1"]) AND empty($row["pass"]) != empty($row["pass1"])) {
			refresh("Поля пароля не совпадает или пароль пустой, что не допустимо.", $_SERVER["HTTP_REFERER"]);
		}else{
			unset($row["pass1"]);
			$row["pass"] = md5($row["pass"]);
		}
		$row['status']=1;
	    if($user_id = $db->query('INSERT INTO ?_users (?#) VALUES(?a)', array_keys($row), array_values($row))){
	    	refresh('ok', $_SERVER["PHP_SELF"]."-show.".$user_id.$config['ext']);
	    }else{
	   	 $db->setErrorHandler('databaseErrorHandler');
	   	 exit;
	    }
	}
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}

?>
