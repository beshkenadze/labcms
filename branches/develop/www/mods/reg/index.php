<?php

if (access('read'))
{
  include "functions.php";
  switch ($_REQUEST['action'])
  {
   case("insert"):
   include dirname(__FILE__)."/insert.php";
   break;
   case("activation"):
   include dirname(__FILE__)."/activation.php";
   break;
   case("check"):
   include dirname(__FILE__)."/check_login.php";
   break;
   default:
   include dirname(__FILE__)."/form.php";
  }
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}

?>