<?php
$mod_template = "user_view.tpl";
$titlepage = "Профиль";
$user_id = (int) $_GET["var1"];
$user = $db->selectRow("
SELECT * FROM ?_users WHERE user_id = ?d;
",$user_id);
$titlepage = $user["realname"] ? "$titlepage :: " . "{$user["realname"]} a.k.a. {$user["login"]}" :"$titlepage :: " . $user["login"];
$core['nav']['path'][]= $_SERVER["PHP_SELF"];
$core['nav']['name'][]= $user["realname"] ? "{$user["realname"]} a.k.a. {$user["login"]}" : $user["login"];
$smarty->assign("user",$user);
?>