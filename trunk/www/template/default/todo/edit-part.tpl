<form action="{$smarty.server.PHP_SELF}-insert.part/{$smarty.get.var2}" method="post">
Имя:
  <input type="text" name="todo[name]" value="{$part.0.name}" size="40" maxlength="40"/>
  <br/><br/>
Родитель:
  <select name="todo[parent_id]">
  <option value="0">Нет родителя</option>
  {foreach from=$sections item=part}
      <option {if $part.0.parent_id == $part.todo_id} selected {/if} value="0">{$part.name} </option>
  {/foreach}
  </select>
  <br/><br/>

  <input type="submit" value="Сохранить"/>
</form>