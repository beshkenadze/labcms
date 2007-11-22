<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="description"/>
		<meta name="keywords" content="keywords"/>
		<meta name="author" content="author"/>
		<base href="{$base}" />
<link rel="stylesheet" type="text/css" href="css/all.css" />
	</head>
<body style="width:468px;" onLoad="mark_modules(document.change_form.mod_group.value); check_component(document.change_form['module[{$imp_module_id}]']); {if $reload}reload_parent(){/if}">
<div id="body" style="width:468px">
<script>
{literal}
function reload_parent()
{
 window.opener.location.reload();
}
function mark_modules(id)
{
 var group = new Array();
 group[null]=new Array();
{/literal}
{foreach key=key item=item from=$groups_js}
group[{$key}]=new Array({$item});
{/foreach}
{literal}
 var i=0;
 while (document.change_form.elements[i])
 {
  if (document.change_form.elements[i].name.substr(0, 6)=='module' && document.change_form.elements[i].disabled==true && document.change_form.elements[i].checked==true) 
  {
   document.change_form.elements[i].checked=false;
   document.change_form.elements[i].disabled=false;
  }
  for (var j=0; j<group[id].length; j++)
  {
   if (document.change_form.elements[i].name=='module['+group[id][j]+']')
   {
    document.change_form.elements[i].checked=true;
    document.change_form.elements[i].disabled=true;
   }
  }
  i++;
 }
}

function check_component(current)
{
 var i=0;
 component=new Array({/literal}{$component}{literal});
 if (current)
 while (document.change_form.elements[i])
 {
  for (var j=0; j<component.length; j++)
  {
   if (document.change_form.elements[i].name=='module['+component[j]+']' && document.change_form.elements[i].checked==false)
   {
    document.change_form.elements[i].disabled=(current.checked) ? true : false;
   }

  }
  i++;
 }
}


function check_form()
{
 var error="";
 if (document.change_form.tree_name.value=="") error=error+"Введите название страницы\n";
 //if (document.change_form.path.value=="") error=error+"Введите путь (URL)\n";
 var i=0;
 var checkbox=false;
 while (document.change_form.elements[i])
 {
  if (document.change_form.elements[i].name.substr(0, 6)=='module' && document.change_form.elements[i].checked==true) checkbox=true;
  i++;
 }
 //if (!checkbox) error=error+"Выберите модули\n";

 if (error)
 {
  alert(error);
  return false;
 }
}
{/literal}
</script>
<table border="0" align="center">
<tr><td>id</td><td>{$tree_id}</td></tr>
<tr><td>
Название</td>
<form action="{$smarty.server.PHP_SELF}.{$tree_id}{$ext}" method="post" name="change_form" onSubmit="return check_form()">
 <td>
   <input name="tree_id" type="hidden" value="{$tree_id}">
   <input class="simple" name="tree_name" type="text" value="{$tree_name|escape}" size="30"> 
 </td>
</tr>
<tr><td>Путь</td>
 <td>
   <input class="simple" type="text" name="path" value="{$tree_path|escape}" size="30">
 </td>
</tr>
<tr><td>Родитель</td>
 <td>
  <select name="parent" style="width:200px">
   {html_options options=$parent_select selected=$parent_id_sel}
  </select>
 </td>
</tr>
<tr><td>Шаблон</td>
 <td>
  <select name="template" style="width:200px">
   {html_options options=$templates selected=$cur_template}
  </select>
 </td>
</tr>
<tr><td>Параметры</td>
 <td><input class="simple" name="params" type="text" value="{$params|escape}" size="30"></td>
</tr>
<tr><td>Группа модулей</td>
 <td>
  <select name="mod_group" style="width:200px" onChange="mark_modules(this.value)">
   <option value="null"></option>
   {html_options options=$groups selected=$cur_group}
  </select>
 </td>
</tr>
<tr><td>Модули</td>
 <td>
{section name=modules loop=$modules_list}
<input class="simple" type="checkbox" name="module[{$modules_list[modules].id}]" {if $modules_list[modules].checked} checked{/if} {if $modules_list[modules].component_js}onClick="check_component(this)"{/if}> {$modules_list[modules].name|escape} <br />
{/section}
 </td>
</tr>
<tr><td colspan="2"><input type="submit" style="width:100%;" value="Сохранить"></td></tr>
</form>
</table>
</div>
</body>
</html>	

