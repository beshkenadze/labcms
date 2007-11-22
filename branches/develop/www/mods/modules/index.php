<?php
if (access('read'))
{
  switch ($_REQUEST['action'])
  {
   case("add"):
   include dirname(__FILE__)."/add.php";
   break;
   case("insert"):
   include dirname(__FILE__)."/insert.php";
   break;
   case("install"):
   include dirname(__FILE__)."/install.php";
   break;
   case("show"):
   include dirname(__FILE__)."/show.php";
   break;
   case("edit"):
   include dirname(__FILE__)."/edit.php";
   break;
   case("delete"):
   include dirname(__FILE__)."/delete.php";
   break;
   case("reinstall"):
   include dirname(__FILE__)."/reinstall.php";
   break;
   case("disable"):
   include dirname(__FILE__)."/disable.php";
   break;
   default:
   include dirname(__FILE__)."/list.php";
  }
}
?>