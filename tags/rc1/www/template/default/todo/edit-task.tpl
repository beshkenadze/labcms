<form action="{$smarty.server.PHP_SELF}-insert.task/{$smarty.get.var2}" method="post">

Имя:
  <input type="text" name="task[name]" value="{$task.name}" size="40" maxlength="40"/>
  <br/><br/>
Раздел:
  <select name="task[parent_id]">
  <option value="0">Нет родителя</option>
  {foreach from=$sections item=part}
      <option {if $part.todo_id == $task.parent_id}selected{/if} value="{$part.todo_id}">{$part.name} </option>
  {/foreach}
  </select>
  <br/><br/>
  <textarea name="task[descr]" rows="10" cols="50" wrap="on">{$task.descr}</textarea>
   <br/><br/>
  <select name="task[type]">
  <option {if $task.type=="*"}selected{/if} value="*">Важно</option>
  <option {if $task.type=="+"}selected{/if} value="+">Возможно</option>
  <option {if $task.type=="?"}selected{/if} value="?">Мысль</option>
  <option {if $task.type=="-"}selected{/if} value="-">Убрать</option>
  </select>
   <br/><br/>

  Неготово:<input checked type="radio" name="task[status]" value="0"/>
  Готово:<input type="radio" name="task[status]" value="1"/>

   <br/><br/>
     Начало: <input value="{$task.start}" type="text" name="task[start]" class="date-start"> 
     <br/><br/>
     Конец: <input value="{$task.end}" type="text"  name="task[end]" class="date-end">
	 <br/><br/>
	 Кому: <select name="task[to_user_id]">
  <option  {if !$task.to_user_id}selected{/if} value="0">Нет пользователя</option>
  {foreach from=$users item=user}
      <option {if $task.to_user_id==$user.user_id}selected{/if}  value="{$user.user_id}">{if $user.realname}{$user.realname}{else}{$user.login}{/if} </option>
  {/foreach}
  </select> <br/>
	 Группе: <select name="task[to_group_id]">
  <option {if !$task.to_group_id}selected{/if} value="0">Нет группы</option>
  {foreach from=$groups item=group}
      <option {if $task.to_group_id==$group.group_id}selected{/if} value="{$group.group_id}">{$group.group_name} </option>
  {/foreach}
  </select>
  <br/>
  <input type="submit" value="Сохранить"/>
</form>
{literal}
<script>
$.datePicker.setDateFormat('ymd','-'); // unicode
$('.date-start').datePicker();
$('.date-end').datePicker();
</script>
{/literal}