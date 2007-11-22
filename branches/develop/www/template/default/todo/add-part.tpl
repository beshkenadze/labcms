<form action="{$smarty.server.PHP_SELF}-insert.part" method="post">
Имя:
  <input type="text" name="todo[name]" value="" size="40" maxlength="40"/>
  <br/><br/>
Родитель:
  <select name="todo[parent_id]">
  <option value="0">Нет родителя</option>
  {foreach from=$sections item=part}
      <option  value="{$part.todo_id}">{$part.name} </option>
  {/foreach}
  </select>
  <br/><br/>

  <input type="submit" value="Сохранить"/>
</form>