<?php
/*
 * Created on 04.03.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */

 $count = $db->selectCell("SELECT count(*) FROM ?_users l WHERE login like ? LIMIT 1",$_POST["login"]);
 $smarty->assign("count",$count);
 $smarty->display("reg/check_login.tpl");
 exit;
?>
