<?
if (access('edit')) {
  $tree_id=intval($_GET['var1']);
  $reload=0;
//$smarty->clear_all_assign;
//$smarty->debugging=true;
  if ($_SERVER['REQUEST_METHOD']=="POST")
  {
   //обнуляем данные текущих сессий
   reset_session_set();

    $path=trim($_POST['path']);
   if ($path)
   {
    $path=convert_url($path);
   }
   else
   {
    $path=NULL;
   }

   if ($tree_id)
   {
    //изменяем родителя
    $result=$db->query("UPDATE ?_tree SET parent_id=? WHERE tree_id=?",$_POST['parent'] ,$tree_id);
	//если изменился родитель - перезагружаем главное окно
	$reload+=$result;
    $result=$db->query("UPDATE ?_tree_val SET
            tree_name=?
               WHERE tree_id=?",$_POST['tree_name'] ,$tree_id);
	//если изменилось название - перезагружаем главное окно
	$reload+=$result;
	$query=array(params=>$_POST['params'],
            group_id=>$_POST['mod_group'],
            template=>$_POST['template'],
            path=>$path);
    $db->query("UPDATE ?_tree_val SET ?a
               WHERE tree_id=?",$query ,$tree_id);
	unset($query);
	
    $db->query("DELETE FROM ?_includes WHERE tree_id=?", $tree_id);
   }
   else
   {
     $tree_id=$db->query("INSERT INTO ?_tree VALUES(NULL,?)",$_POST['parent']);
	 $query=array('tree_id'=>$tree_id, 
                  'tree_name'=>$_POST['tree_name'],
                  'params'=>$_POST['params'],
                  'group_id'=>$_POST['mod_group'],
                  'template'=>$_POST['template'],
				  'path'=>$path);
				  
     $db->query("INSERT INTO ?_tree_val SET ?a", $query);
	 unset($query);
	$reload+=$tree_id;
   }
    if (count($_POST['module']))
    {
     foreach ($_POST['module'] as $key=>$val)
     {
      $db->query("INSERT INTO ?_includes VALUES(NULL, ?, NULL, ?)", $tree_id, $key);
     }
    }
    $smarty->assign('reload', $reload);
  }
  
/////////////////////////////////////////
//тут пошло построение формы
  //выбираем из базы данные о конкретной записи
  $item=$db->selectRow("SELECT t.tree_id, tree_name, template, params, path, parent_id, group_id FROM ?_tree_val tv JOIN ?_tree t ON tv.tree_id=t.tree_id WHERE t.tree_id=?", $tree_id);
  $smarty->assign(array("tree_id"=>$tree_id,
                      "tree_name"=>$item['tree_name'],
                      "params"=>$item['params'],
                      "tree_path"=>$item['path'],
                      "imp"=>$item['imp']));


  $templates=array("");
	 foreach (glob($_SERVER["DOCUMENT_ROOT"]."/".TEMPLATE_PATH.$config['skin']."/*.tpl") as $tpl_name)
	  {
	   $templates[basename($tpl_name,".tpl")]=basename($tpl_name,".tpl");
	  }  
  $smarty->assign('cur_template', $item['template']);
  $smarty->assign('templates', $templates);
 
  function select_tree($parent_id=0, $level=0)
  {
   global $tbl_tree, $tbl_tree_val, $item, $parent_select, $db;
   $result=$db->select("SELECT t.tree_id,  tree_name,  pos FROM ?_tree t JOIN ?_tree_val tv ON t.tree_id=tv.tree_id  WHERE t.parent_id=? ORDER BY pos", $parent_id);
   foreach($result as $tree)
   {
    if ($tree['tree_id']==$item['tree_id']) continue;
    $margin="";
    for($i=0; $i<$level*3; $i++) $margin.="&nbsp;";
    $parent_select[$tree['tree_id']]=$margin.$tree['tree_name'];
    select_tree($tree['tree_id'], $level+1);
   }
  }
  $parent_select=array("");
  select_tree();
  $smarty->assign('parent_id_sel', $item['parent_id']);
  $smarty->assign('parent_select', $parent_select);

 
	//выбираем группы модулей
  $result=$db->select("SELECT i.group_id, module_id, name FROM ?_includes i LEFT JOIN ?_group_inc gi USING(group_id) WHERE i.group_id IS NOT NULL");
  foreach($result as $groups)
  {
   $group[$groups['group_id']][]=$groups['module_id'];
   $group_name[$groups['group_id']]=$groups['name'];
  }
  $groups=array();
  $groups_js=array();
  if (count($group))
	{
	  foreach ($group as $key=>$val)
	  {
	   $groups[$key]=$group_name[$key];
	   $groups_js[$key]=implode(",", $val);
	  }
	  $smarty->assign('groups',$groups);
	}
  $smarty->assign('groups_js',$groups_js);
  $smarty->assign('cur_group',$item['group_id']);
	
	//выбираем список модулей
  $result=$db->select("SELECT m.module_id, name, i.tree_id, component FROM ?_modules m LEFT JOIN ?_includes i ON m.module_id=i.module_id   AND i.tree_id=? WHERE m.disable = 0 ORDER BY name", $tree_id);
  
  foreach($result as $modules)
  {
   $component_js=0; //отображение js в чекбоксе
   $checked=0; //отметка чекбокса
   //если модуль многостраничный, то заносим его идентификатор в массив и вставляем яваскрипт в его чекбокс
   if ($modules['component'])
   {
    $mult[]=$modules['module_id'];
    $component_js=1; //отображаем js для многостраничного модуля
   }
   //если текущий модуль выбран, то помечаем его
   if ($modules['tree_id'])
   {
    $checked=1; //отмечаем чекбокс
    //если модeль выбранный и многостраничный, то заносим его идентификатор в яваскрипт вызываемый из боди
    if ($modules['component']) $smarty->assign("imp_module_id", $modules['module_id']);
   }
   $modules_list[]=array("id"=>$modules['module_id'], "name"=>$modules['name'], 'checked'=>$checked, 'component_js'=>$component_js);
  }
$smarty->assign('modules_list', $modules_list);
$smarty->assign("component", implode(",", $mult));
if (!file_exists($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH.$config['skin']."/tree/edit.tpl")) $smarty->display($_SERVER['DOCUMENT_ROOT']."/".TEMPLATE_PATH."default/tree/edit.tpl");
else
$smarty->display("tree/edit.tpl");

exit();
}else{
	refresh('Доступ закрыт',$_SERVER["HTTP_REFERER"]);
}
?>