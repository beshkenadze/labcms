<form action="{$smarty.server.PHP_SELF}-insert.task" method="post">

Имя:
  <input type="text" name="task[name]" value="" size="40" maxlength="40"/>
  <br/><br/>
Раздел:
  <select name="task[parent_id]">
  <option value="0">Нет родителя</option>
  {foreach from=$sections item=part}
      <option {if $part.todo_id == $smarty.get.var2}selected{/if} value="{$part.todo_id}">{$part.name} </option>
  {/foreach}
  </select>
  <br/><br/>
  <textarea name="task[descr]" rows="10" cols="50" wrap="on"></textarea>
   <br/><br/>
  <select name="task[type]">
  <option value="*">Важно</option>
  <option value="+">Возможно</option>
  <option value="?">Мысль</option>
  <option value="-">Убрать</option>
  </select>
   <br/><br/>

  Неготово:<input checked type="radio" name="task[status]" value="0"/>
  Готово:<input type="radio" name="task[status]" value="1"/>

   <br/><br/>
     Начало: <input type="text" name="task[start]" class="date-start"> 
     <br/><br/>
     Конец: <input type="text"  name="task[end]" class="date-end">
	 <br/><br/>
	 Кому: <select name="task[to_user_id]">
  <option selected value="0">Нет рпользователя</option>
  {foreach from=$users item=user}
      <option value="{$user.user_id}">{if $user.realname}{$user.realname}{else}{$user.login}{/if} </option>
  {/foreach}
  </select> <br/>
	 Группе: <select name="task[to_group_id]">
  <option selected value="0">Нет группы</option>
  {foreach from=$groups item=group}
      <option  value="{$group.group_id}">{$group.group_name} </option>
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