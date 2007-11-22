<?
 $mod_template="login.tpl";
 if ($_GET['action']=='logout')
 {
  $_SESSION['user_id']==-1;
  session_destroy();
  setcookie('pass', '', 0, "/");
   refresh("Выход",$_SERVER["HTTP_REFERER"]);
   exit();
 }

 if($_SESSION['user_id']==-1 && $_POST['login'] && $_POST['pass'])
 {
  if (check_login($_POST['login'], $_POST['pass']))
  { 
	$smarty->assign('login_secsess', 1);
  }
  else
  {
	$smarty->assign('login_deny', 1);
  }
 }
 elseif($_SESSION['user_id']>0)
 {
        $smarty->assign('login_logged', 1);
 }
?>
