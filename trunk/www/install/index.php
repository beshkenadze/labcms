<?php
/*
 * Created on flex 22.03.2007
 * author Beshkenadze Aleksandr a.k.a akira
 */
 error_reporting(7);
if(file_exists("../kernel/configs/install.lock")) exit("Удалите install.lock");
if($_POST){
	require_once "../kernel/engines/DbSimple/Generic.php";
	require_once "../kernel/functions/functions.php";
	foreach($_POST["mysql"] as $key=>$var){
		$$key=$var;
		$vars [] = "$key=$var";
	}
	$db = DbSimple_Generic::connect("mysql://$dbuser:$dbpasswd@$dblocation/$dbname");
	$db->query("set names utf8");
	//задаем префикс для таблиц
	$db->setIdentPrefix($prefix."_");
	if($db->error){
		echo "<pre>";
		print_r($db->error["message"]);
		echo "</pre>";
		exit("<a href='/install/index.php?".implode("&",$vars)."'>back</a>");
	}else{
		echo "Настройки БД верные!<br/>";
		$ini =  "[mysql]
dblocation = \"$dblocation\";
dbname = \"$dbname\";
dbuser = \"$dbuser\";
dbpasswd = \"$dbpasswd\";
prefix = \"{$prefix}_\";";
$fopen = @fopen("../kernel/configs/cms.ini","w");
echo @fwrite($fopen,$ini) ? "Файл настроек успешно записан. <br/>" : exit("Установите права на запись для каталога /kernel/configs/ или файла /kernel/configs/cms.ini<br/><a href='/install/index.php?".implode("&",$vars)."'>back</a>");
fclose($fopen);
echo "<div style='overflow:auto; height:300px; border:1px solid'>";
$result=parse_mysql_dump("./kernel.sql");
echo "</div>";
echo $result ? "База развернута успешно.<br/>" : "Во время разворачивания базы произошла оашибка!<br/>";
echo @chmod("../template_c",0777) ? "Права на template_c выставлены. <br/>" : "PHP не может выставить права 0777 на папку /template_c. Небходимо сделать это вручную. <br/>";
echo @chmod("../storage",0777) ? "Права на images выставлены. <br/>" : "PHP не может выставить права 0777 на папку /storage. Небходимо сделать это вручную. <br/>";
echo "Установка завершена! <a href='/'>Перейти на сайт</a> <br/>";
$fo = fopen("../kernel/configs/install.lock","w");
$date = date("d.m.y");
fwrite($fo,$date);
fclose($fo);

}

}else{
	$cmsini = @parse_ini_file("../kernel/configs/cms.ini",true);
?>
<form action="/install/index.php" method="post">
  <table>
    <tr>
      <td>dblocation</td>
      <td><input value="<?if(isset($_GET["dblocation"])){echo $_GET["dblocation"];}else{echo ($cmsini['mysql']['dblocation']?$cmsini['mysql']['dblocation']:"localhost");}?>" type="text" name="mysql[dblocation]"></td>
    </tr>
    <tr>
      <td>dbname</td>
      <td><input value="<?if(isset($_GET["dbname"])){echo $_GET["dbname"];}else{echo $cmsini['mysql']['dbname'];}?>" type="text" name="mysql[dbname]"></td>
    </tr>
    <tr>
      <td>dbuser</td>
      <td><input value="<?if(isset($_GET["dbuser"])){echo $_GET["dbuser"];}else{echo $cmsini['mysql']['dbuser'];}?>" type="text" name="mysql[dbuser]"></td>
    </tr>
    <tr>
      <td>dbpasswd</td>
      <td><input value="<?if(isset($_GET["dbpasswd"])){echo $_GET["dbpasswd"];}else{echo "";}?>" type="text" name="mysql[dbpasswd]"></td>
    </tr>
    <tr>
      <td>prefix</td>
      <td><input value="<?if(isset($_GET["prefix"])){echo $_GET["prefix"];}else{echo ($cmsini['mysql']['prefix']?substr($cmsini['mysql']['prefix'], 0, -1):"labcms");}?>" type="text" name="mysql[prefix]"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" value="Сохранить"></td>
    </tr>
  </table>
</form>
<?
}
?>
